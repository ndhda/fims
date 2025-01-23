<?php

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
        Schema::create('user_management', function (Blueprint $table) {
            $table->id('user_id'); // Primary key for user_management
            $table->string('email')->unique();
            $table->string('password');
            // Modify foreign key to reference the correct column 'loa_code' in 'level_of_access'
            $table->foreignId('loa_code')->references('loa_code')->on('level_of_access');
            // Modify foreign key to reference the correct column 'role_id' in 'roles'
            $table->foreignId('role_id')->references('role_id')->on('roles');
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
        Schema::table('user_management', function (Blueprint $table) {
            $table->dropForeign(['loa_code']);
            $table->dropForeign(['role_id']);
        });
        Schema::dropIfExists('user_management');
    }
};
