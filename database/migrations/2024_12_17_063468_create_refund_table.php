<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('refund', function (Blueprint $table) {
            $table->id('refund_id');
            $table->string('refund_type');
            $table->text('message');
            $table->decimal('total_refund', 10, 2);
            $table->string('receipt_depo');
            $table->date('date_applied');
            $table->enum('status', ['pending', 'approved', 'denied']);
            $table->text('comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('refund');
    }
};
