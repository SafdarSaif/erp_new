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
        Schema::table('student_queries', function (Blueprint $table) {
        $table->unsignedBigInteger('added_by')->nullable()->after('id');
        $table->timestamp('answered_at')->nullable()->after('added_by');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_queries', function (Blueprint $table) {
           $table->dropColumn(['added_by', 'answered_at']);
        });
    }
};
