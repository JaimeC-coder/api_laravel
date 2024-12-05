<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\UnitMeasurement;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UnitMeasurement>
 */
class UnitMeasurementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = UnitMeasurement::class;
    public function definition(): array
    {
        return [

            'unitName' => $this->faker->unique()->word(),
            'abbreviation' => $this->faker->unique()->lexify(str_repeat('?', 10)),
            'description' => $this->faker->sentence,
        ];
    }
}
