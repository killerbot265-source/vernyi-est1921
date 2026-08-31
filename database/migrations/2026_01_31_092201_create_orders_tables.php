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
        // 1. Таблица самих заказов
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');  // Имя клиента
            $table->string('customer_phone'); // Телефон
            $table->string('status')->default('new'); // Статус (новый, обработан)
            $table->integer('total_price');   // Общая сумма
            $table->timestamps();
        });

        // 2. Таблица товаров внутри заказа
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete(); // Связь с заказом
            $table->foreignId('product_id')->constrained(); // Какой товар
            $table->integer('quantity'); // Сколько штук
            $table->integer('price');    // Цена на момент покупки
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders_tables');
    }
};
