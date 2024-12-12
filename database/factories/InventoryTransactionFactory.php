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


        // $logId = DB::table('time_seeders')->insertGetId([
        //     'seeder_name' => 'I03 - Pos',
        //     'started_at' => Carbon::now(),
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);
        // $randomMinutes = rand(5, 10);


        // $finishedAt = Carbon::now()->addMinutes($randomMinutes);
        $transactionType = $this->faker->randomElement(['input', 'output']);
        $transactionClase = $transactionType === 'input' ? 'purchase' : $this->faker->randomElement(['sale', 'production']);

        $result = [
            'productUnitPriceId' => ProductUnitPriceByMeasurement::inRandomOrder()->first()->unitMeasurementId,
            'userId' => User::inRandomOrder()->first()->id,
            'transactionType' => $transactionType,
            'transactionClase' => $transactionClase,
            'transactionCount' => $this->faker->randomFloat(2, 1, 100),
            //'transactionDate' => $this->faker->dateTimeBetween('2024-09-23', '2024-12-6')->format('Y-m-d'),
             'transactionDate' => $this->faker->dateTimeBetween('2024-12-06', '2024-12-12')->format('Y-m-d'),

        ];
        // DB::table('time_seeders')->where('id', $logId)->update([
        //     'finished_at' => $finishedAt,
        //     'updated_at' => Carbon::now(),
        // ]);

        return $result;
    }
}
