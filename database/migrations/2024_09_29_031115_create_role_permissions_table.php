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
        Schema::create('role_permissions', function (Blueprint $table) {
            $table->bigIncrements('rolePermissionId');
            $table->unsignedBigInteger('roleId')->unsigned();
            $table->unsignedBigInteger('permissionId');
            $table->foreign('roleId')->references('roleId')->on('roles');
            $table->foreign('permissionId')->references('permissionId')->on('permissions');
            $table->unique(['roleId', 'permissionId']);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_permissions');
    }
};
