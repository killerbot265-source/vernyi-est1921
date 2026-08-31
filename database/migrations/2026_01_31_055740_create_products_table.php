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
            
            // Наши новые поля
            $table->string('name'); // Название
            $table->integer('price'); // Цена
            $table->string('image')->nullable(); // Фото (может быть пустым)
            $table->boolean('is_active')->default(true); // Активен ли
            
            $table->timestamps();
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
