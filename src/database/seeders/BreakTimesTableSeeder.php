<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BreakTimesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $id = 74;
        $break_times = [
            [
                'user_id' => $id,
                'break_start' => '2023-10-16 12:00:00',
                'break_end' => '2023-10-16 12:20:00',
            ],
            [
                'user_id' => $id,
                'break_start' => '2023-10-16 14:00:00',
                'break_end' => '2023-10-16 14:15:00',
            ],
        ];

        foreach ($break_times as $break_time) {
            DB::table('break_times')->insert([
                'user_id' => $break_time['user_id'],
                'break_start' => $break_time['break_start'],
                'break_end' => $break_time['break_end'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
