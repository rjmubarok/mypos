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
        Schema::create('institutes', function (Blueprint $table) {
           $table->id();
            $table->string('name'); // সাধারণত institute এর নাম null হওয়া উচিত নয়
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('eiin_no')->nullable(); // eiinno → eiin_no করা হলো
            $table->string('address')->nullable();

            $table->text('about')->nullable();
            $table->text('description')->nullable();
            $table->string('slogan')->nullable(); // slogane → slogan

            $table->string('logo')->nullable();
            $table->string('favicon')->nullable();
            $table->string('banner')->nullable();

            $table->string('facebook_url')->nullable(); // longText না, string-ই যথেষ্ট
            $table->string('team_color')->default('bg-gradient');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('institutes');
    }
};
