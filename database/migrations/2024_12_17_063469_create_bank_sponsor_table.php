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
        Schema::create('bank_sponsor', function (Blueprint $table) {
            $table->id('bank_sponsor_id');
            $table->string('bank_name');
            $table->string('bank_acc_num');
            $table->string('sponsor_name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_sponsor');
    }
};
