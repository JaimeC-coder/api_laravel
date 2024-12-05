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
        Schema::create('product_unit_price_by_measurements', function (Blueprint $table) {
            $table->bigIncrements('productUnitPriceId');
            $table->unsignedBigInteger('productId');
            $table->unsignedBigInteger('unitMeasurementId');
            $table->decimal('price', 10, 2)->default(0);
            $table->date('effectiveDate');
            $table->foreign('productId')->references('productId')->on('products');
            $table->foreign('unitMeasurementId')->references('unitMeasurementId')->on('unit_measurements');
            $table->unique('productUnitPriceId');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_unit_price_by_measurements');
    }
};
