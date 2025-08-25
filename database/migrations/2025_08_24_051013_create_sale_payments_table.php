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
        Schema::create('sale_payments', function (Blueprint $table) {
            $table->id();
              
            $table->foreignId('sale_id')->constrained('sales')->cascadeOnDelete();
            $table->dateTime('paid_at');
            $table->decimal('amount', 16, 2);
            $table->string('method'); // cash/card/bkash/nagad/bank
            $table->string('txn_id')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();

            $table->index(['sale_id','paid_at']);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_payments');
    }
};
