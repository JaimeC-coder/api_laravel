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
        Schema::create('staff', function (Blueprint $table) {
            $table->bigIncrements('staffId');
            $table->string('stafffirstName');
            $table->string('stafflastName');
            $table->date('staffBirthDate');
            $table->enum('staffGender', ['M', 'F'])->default('M');
            $table->string('staffDni', 25)->unique();
            $table->string('staffAddress');
            $table->string('staffPhone', 15);
            $table->string('staffPhoto')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
