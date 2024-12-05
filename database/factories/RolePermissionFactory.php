<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\RolePermission;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RolePermission>
 */
class RolePermissionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = RolePermission::class;
    public function definition(): array
    {
        do {
            // Obtener usuarios y roles de forma aleatoria
            $permissionId = Permission::all()->random()->permissionId;
            $roleId = Role::all()->random()->roleId;

            // Verificar si ya existe la combinación
            $exists = DB::table('role_permissions')
                        ->where('permissionId', $permissionId)
                        ->Where('roleId', $roleId)
                        ->exists();
        } while ($exists);

        return [
            'roleId' => $roleId,
            'permissionId' => $permissionId,
        ];

    }
}
