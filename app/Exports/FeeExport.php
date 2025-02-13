<?php

namespace App\Exports;

use App\Models\Fee;
use Maatwebsite\Excel\Concerns\FromCollection;

class FeeExport implements FromCollection
{
    protected $feeIds;

    public function __construct(array $feeIds)
    {
        $this->feeIds = $feeIds;
    }

    public function collection()
    {
        return Fee::whereIn('fee_id', $this->feeIds)->select('invoice_num', 'total_amount', 'amount_balance', 'fee_status_id')->get();
    }
}

