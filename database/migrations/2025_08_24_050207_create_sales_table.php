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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            // who made the sale
            $table->foreignId('user_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            // optional: which counter/shop/branch
             $table->unsignedBigInteger('customer_id')->nullable(); 

        $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
           

            // identifiers
            $table->string('invoice_no')->unique();
            $table->dateTime('sold_at')->index();

            // money
            $table->decimal('subtotal', 16, 2);
            $table->decimal('discount', 16, 2)->default(0);
            $table->enum('discount_type', ['flat','percent'])->default('flat');
            $table->decimal('tax', 16, 2)->default(0);
            $table->decimal('shipping', 16, 2)->default(0);
            $table->decimal('grand_total', 16, 2);      // subtotal - discount + tax + shipping
            $table->decimal('paid_amount', 16, 2)->default(0);
            $table->decimal('due_amount', 16, 2)->virtualAs('grand_total - paid_amount'); // MySQL 5.7+/MariaDB 10.2+

            // payment + status
            $table->enum('payment_status', ['unpaid','partial','paid','refunded'])->default('unpaid')->index();
            $table->enum('status', ['draft','completed','void'])->default('completed')->index();

            // meta
            $table->string('payment_method')->nullable();  // cash, card, bkash, nagad, etc.
            $table->string('reference_no')->nullable();    // POS ref, txn id
            $table->text('note')->nullable();

            $table->softDeletes();
            $table->timestamps();

            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
