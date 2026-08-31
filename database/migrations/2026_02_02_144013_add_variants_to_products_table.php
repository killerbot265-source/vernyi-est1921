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
        Schema::table('products', function (Blueprint $table) {
            $table->json('sizes')->nullable();          // Список размеров ["S", "M", "L"]
            $table->json('colors')->nullable();         // Список цветов ["Black", "White"]
            $table->json('specifications')->nullable(); // Характеристики {"Material": "Cotton", "Style": "Oversize"}
            $table->text('description')->change();      // Убедимся, что описание вмещает много текста
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            //
        });
    }
};
