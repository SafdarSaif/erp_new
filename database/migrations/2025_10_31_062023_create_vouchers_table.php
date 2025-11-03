<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('voucher_type');
            $table->date('date')->default(DB::raw('CURRENT_DATE'));
            $table->unsignedBigInteger('expense_category_id')->nullable();
            $table->decimal('amount', 10, 2);
            $table->string('payment_mode');
            $table->text('description')->nullable();
            $table->string('attachment')->nullable();
            $table->string('status')->default('0');//0-Pending Approval, 1-Approved, 2-Rejected
            $table->unsignedBigInteger('added_by')->nullable();
            $table->timestamps();

            // ✅ Foreign key constraint
            $table->foreign('expense_category_id')
                ->references('id')
                ->on('expense_categories')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
