<?php

namespace Database\Seeders;

use App\Models\Weekday;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WeekdaySeeder extends Seeder
{
    public array $days = [
        [
            'name' => 'Sunday',
            'session_duration' => 90,
            'start_time' => '08:00:00',
            'end_time' => '17:00:00',
            'is_working_day' => true,
        ],
        [
            'name' => 'Monday',
            'session_duration' => 60,
            'start_time' => '08:00:00',
            'end_time' => '17:00:00',
            'is_working_day' => true,
        ],
        [
            'name' => 'Tuesday',
            'session_duration' => 90,
            'start_time' => '08:00:00',
            'end_time' => '17:00:00',
            'is_working_day' => true,
        ],
        [
            'name' => 'Wednesday',
            'session_duration' => 60,
            'start_time' => '08:00:00',
            'end_time' => '17:00:00',
            'is_working_day' => true,
        ],
        [
            'name' => 'Thursday',
            'session_duration' => 90,
            'start_time' => '08:00:00',
            'end_time' => '17:00:00',
            'is_working_day' => true,
        ],
        [
            'name' => 'Friday',
            'session_duration' => 60,
            'start_time' => '08:00:00',
            'end_time' => '17:00:00',
            'is_working_day' => false,
        ],
        [
            'name' => 'Saturday',
            'session_duration' => 60,
            'start_time' => '08:00:00',
            'end_time' => '17:00:00',
            'is_working_day' => false,
        ]
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->days as $day) {
            Weekday::create($day);
        }
    }
}
