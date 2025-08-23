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
        Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('category_id');   // Foreign Key → categories
        $table->unsignedBigInteger('brand_id')->nullable(); // Foreign Key → brands
        $table->unsignedBigInteger('supplier_id')->nullable(); // Foreign Key → suppliers

        $table->string('name'); // Product Name
        $table->string('slug')->unique(); // SEO Friendly Slug
        $table->string('sku')->unique()->nullable(); // Stock Keeping Unit / Code
        $table->string('barcode')->nullable();
        $table->text('description')->nullable();
        $table->string('image')->nullable();
        $table->decimal('purchase_price', 10, 2)->default(0.00);
        $table->decimal('selling_price', 10, 2)->default(0.00);
        $table->integer('stock')->default(0);
        $table->integer('alert_quantity')->default(5);
         $table->boolean('status')->default(1); // 1 = Active, 0 = Inactive
        $table->timestamps();
        // Foreign Keys
        $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        $table->foreign('brand_id')->references('id')->on('brands')->onDelete('set null');
        $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('set null');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
