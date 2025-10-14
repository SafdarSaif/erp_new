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
        Schema::create('themes', function (Blueprint $table) {
            $table->id();
           $table->string('name'); // Theme name
            $table->string('main_color')->default('#3B82F6'); // Primary theme color
            $table->string('top_color')->default('#1E3A8A'); // Top bar/header color
            $table->string('secondary_color')->default('#64748B'); // Secondary color
            $table->string('logo')->nullable(); // Logo image path
            $table->string('favicon')->nullable(); // Favicon path
            $table->json('custom_colors')->nullable(); // For extra colors in JSON
            $table->boolean('is_active')->default(true); // Active/inactive
            $table->string('tag_line')->nullable(); // Theme tagline or slogan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('themes');
    }
};
