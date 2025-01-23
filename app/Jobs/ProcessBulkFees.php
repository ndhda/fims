<?php

namespace App\Jobs;

use App\Models\BulkFeeOperation;
use App\Models\Fee;
use App\Models\FeeHistory;
use App\Models\FeeStatus;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProcessBulkFees implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $operationId;
    public array $data;

    /**
     * Create a new job instance.
     */
    public function __construct(int $operationId, array $data)
    {
        $this->operationId = $operationId;
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        // Retrieve the operation record
        $operation = BulkFeeOperation::find($this->operationId);

        if (!$operation) {
            return;
        }

        try {
            DB::transaction(function () use ($operation) {
                foreach ($this->data['students'] as $studentId) {
                    foreach ($this->data['fee_categories'] as $index => $feeCategoryId) {
                        // Create fee record
                        Fee::create([
                            'student_id' => $studentId,
                            'fee_category_id' => $feeCategoryId,
                            'total_amount' => $this->data['total_amounts'][$index],
                            'due_date' => $this->data['due_date'],
                            'description' => $this->data['description'] ?? null,
                            'year_id' => $this->data['year_id'],
                            'session_id' => $this->data['session_id'],
                            'amount_balance' => $this->data['total_amounts'][$index],
                            'fee_status_id' => FeeStatus::where('fee_status_name', 'Unpaid')->first()->fee_status_id,
                        ]);

                        // Log creation in fee history
                        FeeHistory::create([
                            'fee_id' => DB::getPdo()->lastInsertId(),
                            'action' => 'created',
                            'admin_id' => $operation->admin_id,
                            'action_date' => now(),
                        ]);
                    }
                }

                // Update operation status to completed
                $operation->update(['status' => 'completed']);
            });
        } catch (\Exception $e) {
            // Log the failure
            $operation->update(['status' => 'failed']);
            Log::error('Bulk fee creation failed: ' . $e->getMessage());
        }
    }
}
