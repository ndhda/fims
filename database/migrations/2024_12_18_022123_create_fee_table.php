<?php

// ModifyFeeTable.php
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
        Schema::create('fee', function (Blueprint $table) {
            $table->id('fee_id');
            $table->string('fee_category');
            $table->text('description');
            $table->decimal('total_amount', 10, 2);
            $table->foreignId('amount_paid_id')->nullable()->references('amount_paid_id')->on('amount_paid');
            $table->decimal('amount_balance', 10, 2);
            $table->foreignId('year_id')->references('year_id')->on('year');
            $table->enum('status', ['paid', 'pending', 'unpaid']);
            $table->unsignedBigInteger('student_id'); // Match with students table
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('fee', function (Blueprint $table) {
            // Drop the existing foreign keys
            $table->dropForeign(['amount_paid_id']);
            $table->dropForeign(['year_id']);
            $table->dropForeign(['student_id']);
        });

        Schema::dropIfExists('fee');
    }

};
