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
        Schema::create('shoppings', function (Blueprint $table) {
            $table->bigIncrements('shoppingId');
            $table->unsignedBigInteger('userId');
            $table->date('shoppingDate');
            $table->string('name');//nombre del proveedor
            $table->string('email');//correo del proveedor
            $table->string('address');//direccion del proveedor
            $table->string('phone');//telefono del proveedor
            $table->string('bankInfoNo');//informacion bancaria del proveedor
            $table->string('bankInfoName');//informacion bancaria del proveedor
            $table->decimal('total', 10, 2)->default(0);
            $table->foreign('userId')->references('id')->on('users');
            $table->unique('shoppingId');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shoppings');
    }
};
