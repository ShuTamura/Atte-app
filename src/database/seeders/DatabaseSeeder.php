<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WorkHour;
use App\Models\BreakTime;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User::factory(10)->create();
        WorkHour::factory(100)->create();
        // $this->call(BreakTimesTableSeeder::class);
    }
}
