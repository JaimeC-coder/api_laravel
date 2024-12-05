<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;
use App\Models\UnitMeasurement;
use App\Models\ProductUnitPriceByMeasurement;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductUnitPriceByMeasurement>
 */
class ProductUnitPriceByMeasurementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = ProductUnitPriceByMeasurement::class;
    public function definition(): array
    {
        return [
            'productId' => Product::inRandomOrder()->first()->productId,
            'unitMeasurementId' => UnitMeasurement::inRandomOrder()->first()->unitMeasurementId,
            'price' => $this->faker->randomFloat(2, 1, 100),
            'effectiveDate' => $this->faker->date(),
        ];
    }
}
