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
        Schema::create('shopping_details', function (Blueprint $table) {
            $table->bigIncrements('shoppingDetailId');
            $table->unsignedBigInteger('shoppingId');
            $table->unsignedBigInteger('productUnitPriceId');
            $table->decimal('quantity', 10, 2)->default(0);
            $table->decimal('priceByUnit', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);
            $table->foreign('shoppingId')->references('shoppingId')->on('shoppings');
            $table->foreign('productUnitPriceId')->references('productUnitPriceId')->on('product_unit_price_by_measurements');
            $table->unique('shoppingDetailId');
            $table->softDeletes();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shopping_details');
    }
};
