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
        Schema::create('sale_items', function (Blueprint $table) {
           $table->id();
           $table->unsignedBigInteger('sale_id')->nullable();
           $table->unsignedBigInteger('product_id')->nullable();
            $table->foreign('sale_id')->references('id')->on('sales')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');


            // pricing snapshot (don’t rely on product table later)
            $table->string('product_name');
            $table->string('sku')->nullable();
            $table->decimal('quantity', 16, 4);
            $table->string('unit')->nullable(); // pcs, kg, etc.

            $table->decimal('unit_price', 16, 4);          // selling price before line discounts


            $table->decimal('tax_percent', 8, 4)->default(0);
            $table->decimal('tax_amount', 16, 4)->default(0);

            $table->decimal('total', 16, 4);               // (unit_price - disc + tax) * qty

            $table->timestamps();
  $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_items');
    }
};
