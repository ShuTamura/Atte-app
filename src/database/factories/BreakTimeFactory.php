<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\WorkHour;
use App\Models\User;

class BreakTimeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $get_id = User::select('id')->get();
        $date_between = $this->faker->dateTimeBetween('-1week', '-1day');
        return [
            'user_id' => $this->faker->randomElement($get_id),
            'break_start' => $date_between->format('Y-m-d H:i:s'),
            'break_end' => $date_between->modify('+1hour')->format('Y-m-d H:i:s')
        ];
    }
}
