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
        Schema::table('universities', function (Blueprint $table) {
            $table->string('prefix', 10)->nullable()->after('logo'); // e.g., "HIMS"
            $table->integer('length')->default(0)->after('prefix');   // e.g., 6
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('universities', function (Blueprint $table) {
        $table->dropColumn(['prefix', 'length']);

        });
    }
};
