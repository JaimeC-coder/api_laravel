<?php

namespace Database\Factories;

use App\Models\Inventory;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\InventoryTransaction;
use App\Models\Product;
use App\Models\ProductUnitPriceByMeasurement;
use App\Models\UnitMeasurement;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InventoryTransaction>
 */
class InventoryTransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $transactionType = $this->faker->randomElement(['input', 'output']);
        $transactionClase = $transactionType === 'input'? 'purchase': $this->faker->randomElement(['sale', 'production']);

        return [
            'productUnitPriceId' => ProductUnitPriceByMeasurement::inRandomOrder()->first()->unitMeasurementId,
            'userId' => User::inRandomOrder()->first()->id,
            'transactionType' => $transactionType,
            'transactionClase' => $transactionClase,
            'transactionCount' => $this->faker->randomFloat(2, 1, 100),
            'transactionDate' => $this->faker->dateTimeBetween('2024-01-01', '2024-11-30')->format('Y-m-d'),

        ];
    }
}
