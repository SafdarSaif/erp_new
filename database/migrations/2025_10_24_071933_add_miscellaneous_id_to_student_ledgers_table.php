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
        Schema::table('student_ledgers', function (Blueprint $table) {
        $table->unsignedBigInteger('miscellaneous_id')->nullable()->after('student_fee_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_ledgers', function (Blueprint $table) {
        $table->dropColumn('miscellaneous_id');
        });
    }
};
