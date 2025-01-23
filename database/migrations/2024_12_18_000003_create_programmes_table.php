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
        Schema::create('programmes', function (Blueprint $table) {
            $table->id();
            $table->string('programme_code');
            $table->string('programme_name');
            $table->string('programme_mode');
            $table->integer('program_duration');
            $table->foreignId('level_id')->references('level_id')->on('edu_level');
            $table->foreignId('faculty_id')->references('faculty_id')->on('faculties');
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
        Schema::table('programmes', function (Blueprint $table) {
            $table->dropForeign(['level_id']);
            $table->dropForeign(['faculty_id']);
        });

        Schema::dropIfExists('programmes');
    }
};
