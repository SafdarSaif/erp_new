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
        Schema::create('student_queries', function (Blueprint $table) {
            $table->id();
            $table->string('student_id'); // From students table
            $table->unsignedBigInteger('query_head_id');
            $table->text('query');
            $table->string('attachment')->nullable();
            $table->text('answer')->nullable();
            $table->tinyInteger('status')->default(0); // 0=Pending, 1=Answered
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_queries');
    }
};
