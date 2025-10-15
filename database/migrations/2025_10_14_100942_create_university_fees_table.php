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
        Schema::create('university_fees', function (Blueprint $table) {
            $table->id();

            // Foreign keys
            $table->unsignedBigInteger('student_id')->index();
            $table->unsignedBigInteger('university_id')->index()->nullable();
            $table->unsignedBigInteger('course_id')->index()->nullable();
            $table->string('transaction_id')->nullable();
            // Fee details
            $table->decimal('amount', 10, 2)->default(0);
            $table->enum('mode', ['cash', 'card', 'bankTransfer', 'upi'])->default('cash');
            $table->enum('status', ['pending', 'success', 'failed'])->default('pending');
            $table->date('date')->nullable();
            $table->timestamps();
            // Foreign key constraints (optional but recommended)
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('university_id')->references('id')->on('universities')->onDelete('set null');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('university_fees');
    }
};
