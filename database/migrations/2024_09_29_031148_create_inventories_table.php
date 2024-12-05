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
        Schema::create('stockProductbyMedie', function (Blueprint $table) {
            $table->bigIncrements('inventoryId');
            $table->decimal('currentStock', 10, 2)->default(0);
            $table->boolean('isBox')->default(true);
            $table->unsignedBigInteger('productUnitPriceId');
            $table->foreign('productUnitPriceId')->references('productUnitPriceId')->on('product_unit_price_by_measurements');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stockProductbyMedie');
    }
};
