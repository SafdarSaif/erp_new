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
        Schema::create('student_qualifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->string('qualification')->nullable();
            $table->string('board')->nullable();
            $table->string('passing_year')->nullable();
            $table->string('marks')->nullable();
            $table->string('result')->nullable();
            $table->string('document')->nullable();
            $table->timestamps();

            // Foreign key constraint
              $table->foreign('student_id')
              ->references('id')
              ->on('students')
              ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_qualifications');
    }
};
