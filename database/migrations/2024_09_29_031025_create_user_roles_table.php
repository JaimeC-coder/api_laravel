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
        Schema::create('user_roles', function (Blueprint $table) {
            $table->bigIncrements('userRoleId')->autoIncrement();
            $table->unsignedBigInteger('userId');
            $table->unsignedBigInteger('roleId');
            $table->foreign('userId')->references('id')->on('users');
            $table->foreign('roleId')->references('roleId')->on('roles');
            $table->unique(['userId', 'roleId']);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_roles');
    }
};
