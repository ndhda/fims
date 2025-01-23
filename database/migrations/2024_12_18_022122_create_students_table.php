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
        Schema::create('students', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->string('student_id')->unique(); // Custom student ID
            $table->foreignId('user_id')->constrained('user_management')->onDelete('cascade')->onUpdate('cascade');
            $table->string('student_name');
            $table->foreignId('semester_id')->constrained('semesters')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('faculty_id')->constrained('faculties')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('bank_sponsor_id')->constrained('bank_sponsor')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('clearance_form_id')->nullable()->constrained('clearance_form')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('refund_id')->nullable()->constrained('refund')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::table('students', function (Blueprint $table) {
            // Drop foreign keys in the order they were added
            $table->dropForeign(['user_id']);
            $table->dropForeign(['semester_id']);
            $table->dropForeign(['faculty_id']);
            $table->dropForeign(['bank_sponsor_id']);
            $table->dropForeign(['clearance_form_id']);
            $table->dropForeign(['refund_id']);
        });

        Schema::dropIfExists('students');
    }
};
