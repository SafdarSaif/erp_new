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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('voucher_id')->nullable();
            $table->unsignedBigInteger('user_by')->nullable();
            $table->unsignedBigInteger('added_by')->nullable();
            $table->foreign('voucher_id')->references('id')->on('vouchers')->onDelete('cascade');
            $table->foreign('user_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('added_by')->references('id')->on('users')->onDelete('set null');
            $table->tinyInteger('status')->default(0);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
