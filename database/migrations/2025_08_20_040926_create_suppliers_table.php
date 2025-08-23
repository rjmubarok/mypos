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
        Schema::create('suppliers', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // Supplier Name
        $table->string('shopname')->nullable(); // Company / Firm Name
        $table->string('email')->unique()->nullable();
        $table->string('phone')->nullable();
        $table->string('photo')->nullable();
        $table->string('address')->nullable();
         $table->boolean('status')->default(1); // 1 = Active, 0 = Inactive
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
