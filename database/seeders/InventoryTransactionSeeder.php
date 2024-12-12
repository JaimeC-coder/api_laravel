<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\InventoryTransaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class InventoryTransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
          // Registrar el inicio del seeder
        //   $logId = DB::table('time_seeders')->insertGetId([
        //     'seeder_name' => 'UserSeeder',
        //     'started_at' => Carbon::now(),
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);
        InventoryTransaction::factory(55000)->create();
         // Registrar el fin del seeder
        //  DB::table('time_seeders')->where('id', $logId)->update([
        //     'finished_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);
    }
}
