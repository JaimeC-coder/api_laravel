<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;
use App\Models\Product;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Product::class;
    public function definition(): array
    {

        return [
            'productName' => $this->faker->unique()->word(),
            'productStockMin' => $this->faker->randomFloat(2, 0, 100),
            'productDescription' => $this->faker->sentence(),
            'productPricePurchase' => $this->faker->randomFloat(2, 0, 100),
            'categoryId' => Category::inRandomOrder()->first()->categoryId,
        ];
    }
}
