<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\ProductUnitPriceByMeasurement;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Inventory>
 */
class InventoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Inventory::class;
    public function definition(): array
    {

        return [
           'productUnitPriceId' => ProductUnitPriceByMeasurement::inRandomOrder()->first()->productUnitPriceId,
            'currentStock' => $this->faker->randomFloat(2, 0, 100),
            'isBox' => $this->faker->boolean(),
        ];
    }
}
