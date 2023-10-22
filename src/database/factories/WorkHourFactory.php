<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\WorkHour;
use App\Models\User;

class WorkHourFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $date_between = $this->faker->dateTimeBetween('-1week', '-1day');
        return [
            'user_id' => User::factory(),
            'clock_in' => $this->faker->randomElement([
                $date_between->format('Y-m-d 10:00:00'),
                $date_between->format('Y-m-d 10:00:10'),
                $date_between->format('Y-m-d 10:00:20'),
            ]),
            'clock_out' => $date_between->modify('+9hour')->format('Y-m-d 20:00:00')
        ];
    }
}
