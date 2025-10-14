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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->boolean('is_parent')->default(false);
            $table->string('url')->nullable();
            $table->string('icon')->nullable();
            $table->integer('position')->default(0);
            $table->string('permission')->nullable();
            $table->boolean('is_active')->default(true);
            //$table->boolean('show_logo')->default(false);
            $table->boolean('is_searchable')->default(false);

            $table->timestamps();


            $table->foreign('parent_id')->references('id')->on('menus')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
