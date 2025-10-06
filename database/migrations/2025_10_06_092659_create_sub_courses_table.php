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
        Schema::create('sub_courses', function (Blueprint $table) {
            $table->id();
              $table->string('name', 100);
            $table->string('short_name', 50);
            $table->unsignedBigInteger('course_id');
            $table->string('image')->nullable();
            $table->boolean('status')->default(1); // 1 for active, 0 for inactive
            $table->timestamps();
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_courses');
    }
};
