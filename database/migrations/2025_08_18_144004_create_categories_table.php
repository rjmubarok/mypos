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
        Schema::create('categories', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('name'); // Category name
            $table->string('slug')->unique(); // URL-friendly name
            $table->foreignId('parent_id')->nullable()->constrained('categories')->onDelete('cascade'); // For subcategories
            $table->text('description')->nullable(); // Optional description
            $table->string('image')->nullable(); // Optional category image
            $table->boolean('status')->default(true); // Status: active/inactive
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
