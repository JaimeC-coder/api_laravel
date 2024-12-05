<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Staff;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Staff>
 */
class StaffFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Staff::class;
    public function definition(): array
    {
        return [
            'stafffirstName' => $this->faker->firstName(),
            'stafflastName' => $this->faker->lastName(),
            'staffBirthDate' => $this->faker->date(),
            'staffGender' => $this->faker->randomElement(['M', 'F']),
            'staffDni' => $this->faker->unique()->numerify('############'),
            'staffAddress' => $this->faker->address(),
            'staffPhone' => $this->faker->numerify('##########'),
        ];
    }
}
