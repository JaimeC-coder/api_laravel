<?php

namespace Database\Factories;

use App\Models\Inventory;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\InventoryTransaction;
use App\Models\Product;
use App\Models\ProductUnitPriceByMeasurement;
use App\Models\UnitMeasurement;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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


        $logId = DB::table('time_seeders')->insertGetId([
            'seeder_name' => 'UserSeeder',
            'started_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $transactionType = $this->faker->randomElement(['input', 'output']);
        $transactionClase = $transactionType === 'input'? 'purchase': $this->faker->randomElement(['sale', 'production']);

        $result = [
            'productUnitPriceId' => ProductUnitPriceByMeasurement::inRandomOrder()->first()->unitMeasurementId,
            'userId' => User::inRandomOrder()->first()->id,
            'transactionType' => $transactionType,
            'transactionClase' => $transactionClase,
            'transactionCount' => $this->faker->randomFloat(2, 1, 100),
            // 'transactionDate' => $this->faker->dateTimeBetween('2024-01-01', '2024-11-30')->format('Y-m-d'),
             'transactionDate' => $this->faker->dateTimeBetween('2010-01-01', '2024-05-30')->format('Y-m-d'),

        ];
         DB::table('time_seeders')->where('id', $logId)->update([
            'finished_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        return $result;

    }
}
