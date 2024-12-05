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
            $table->bigIncrements('productId');
            $table->string('productName')->unique();
            $table->decimal('productStockMin', 10, 2)->default(0);
            $table->string('productDescription')->nullable();
            $table->decimal('productPricePurchase', 10, 2)->default(0);
            $table->unsignedBigInteger('categoryId');
            $table->foreign('categoryId')->references('categoryId')->on('categories');

            $table->softDeletes();
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
