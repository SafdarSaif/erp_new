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
        Schema::table('sub_courses', function (Blueprint $table) {
            // Add mode_id column (foreign key)
            $table->unsignedBigInteger('mode_id')->nullable()->after('image');
            $table->foreign('mode_id')
                  ->references('id')
                  ->on('course_modes')
                  ->onDelete('set null');

            // Add duration column
            $table->string('duration', 100)->nullable()->after('mode_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sub_courses', function (Blueprint $table) {
              $table->dropForeign(['mode_id']);
            $table->dropColumn(['mode_id', 'duration']);
        });
    }
};
