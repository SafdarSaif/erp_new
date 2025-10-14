<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();

            // Foreign keys
            $table->unsignedBigInteger('academic_year_id');
            $table->foreign('academic_year_id')
                ->references('id')->on('academic_years')
                ->onDelete('cascade');

            $table->unsignedBigInteger('university_id');
            $table->foreign('university_id')
                ->references('id')->on('universities')
                ->onDelete('cascade');

            $table->unsignedBigInteger('course_type_id');
            $table->foreign('course_type_id')
                ->references('id')->on('course_types')
                ->onDelete('cascade');

            $table->unsignedBigInteger('course_id');
            $table->foreign('course_id')
                ->references('id')->on('courses')
                ->onDelete('cascade');

            $table->unsignedBigInteger('sub_course_id');
            $table->foreign('sub_course_id')
                ->references('id')->on('sub_courses')
                ->onDelete('cascade');

            $table->unsignedBigInteger('admissionmode_id');
            $table->foreign('admissionmode_id')
                ->references('id')->on('admission_modes')
                ->onDelete('cascade');

            $table->unsignedBigInteger('course_mode_id');
            $table->foreign('course_mode_id')
                ->references('id')->on('course_modes')
                ->onDelete('cascade');

            // Other fields
            $table->string('semester')->nullable();
            $table->string('course_duration')->nullable();
            $table->string('full_name', 150);
            $table->string('father_name', 150)->nullable();
            $table->string('mother_name', 150)->nullable();
            $table->string('aadhaar_no', 20)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('mobile', 15)->nullable();



            $table->unsignedBigInteger('language_id')->nullable();
            $table->foreign('language_id')
                ->references('id')->on('languages')
                ->onDelete('set null');

            $table->date('dob')->nullable();
            $table->string('gender', 10)->nullable();

            $table->unsignedBigInteger('blood_group_id')->nullable();
            $table->foreign('blood_group_id')
                ->references('id')->on('blood_groups')
                ->onDelete('set null');

            $table->unsignedBigInteger('religion_id')->nullable();
            $table->foreign('religion_id')
                ->references('id')->on('religions')
                ->onDelete('set null');

            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')
                ->references('id')->on('categories')
                ->onDelete('set null');

            $table->decimal('income', 10, 2)->nullable();
            $table->text('permanent_address')->nullable();
            $table->text('current_address')->nullable();
            $table->decimal('total_fee', 10, 2)->nullable();
            $table->boolean('status')->default(1); // 1 = active, 0 = inactive
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
