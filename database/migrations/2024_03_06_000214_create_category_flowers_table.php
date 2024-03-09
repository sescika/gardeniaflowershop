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
        Schema::create('category_flowers', function (Blueprint $table) {
            $table->id('id_category_flower');
            $table->foreignId('category_id')->constrained('categories', 'id_category')->onDelete('cascade');
            $table->foreignId('flower_id')->constrained('flowers', 'id_flower')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_flowers');
    }
};
