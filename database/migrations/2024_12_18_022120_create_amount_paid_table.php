<?php

// ModifyAmountPaidTable.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amount_paid', function (Blueprint $table) {
            $table->id('amount_paid_id');
            $table->decimal('amount_paid', 10, 2);
            $table->date('date_paid');
            $table->string('payment_method');
            $table->string('reference_num');
            $table->foreignId('receipt_id')->references('receipt_id')->on('receipt');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('amount_paid', function (Blueprint $table) {
            $table->dropForeign(['receipt_id']);
        });
    }
};
