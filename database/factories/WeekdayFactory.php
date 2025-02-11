<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Weekday>
 */
class WeekdayFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->dayOfWeek(),
            'session_duration' => $this->faker->randomNumber(2),
            'start_time' => $this->faker->time(),
            'end_time' => $this->faker->time(),
            'is_working_day' => $this->faker->boolean(),
        ];
    }
}
