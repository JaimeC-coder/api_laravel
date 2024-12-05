<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\UserRole;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserRole>
 */
class UserRoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = UserRole::class;
    public function definition(): array
    {
        do {
            // Obtener un userId y roleId aleatorios
            $userId = User::all()->random()->id;
            $roleId = Role::all()->random()->roleId;

            // Verificar si ya existe la combinación de userId y roleId
            $exists = DB::table('user_roles')
                        ->where('userId', $userId)
                        ->where('roleId', $roleId)
                        ->exists();
        } while ($exists); // Si existe, intentar nuevamente

        // Retornar la combinación única de userId y roleId
        return [
            'userId' => $userId,
            'roleId' => $roleId,
        ];

    }
}
