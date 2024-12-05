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
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('categoryId');
            $table->string('categoryName')->unique();
            $table->string('categoryDescription')->nullable();
            $table->unsignedBigInteger('parentCategoryId')->nullable();
            $table->foreign('parentCategoryId')->references('categoryId')->on('categories');
            $table->unique('categoryId');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
