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
        Schema::create('inventory_transactions', function (Blueprint $table) {
            $table->bigIncrements('inventoryTransactionId');
            $table->unsignedBigInteger('userId');
            $table->enum('transactionType', ['input', 'output']);
            $table->decimal('transactionCount', 10, 2);
            $table->enum('transactionClase', ['purchase', 'sale','production']);
            $table->date('transactionDate');
            $table->unsignedBigInteger('productUnitPriceId');

            $table->foreign('productUnitPriceId')->references('productUnitPriceId')->on('product_unit_price_by_measurements');
            $table->foreign('userId')->references('id')->on('users')->onDelete('no action');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_transactions');
    }
};
