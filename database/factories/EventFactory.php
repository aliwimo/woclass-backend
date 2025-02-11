<?php

namespace Database\Factories;

use App\Enums\EventStatus;
use App\Models\Classroom;
use App\Models\Event;
use App\Models\User;
use App\Models\Weekday;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        // Get a random working day
        $weekDay = Weekday::query()
            ->where('is_working_day', true)
            ->inRandomOrder()
            ->first();
        $classroom = Classroom::query()->inRandomOrder()->first();
        $user = User::query()->inRandomOrder()->first();

        // Generate a random future date that matches the week day
        $date = $this->generateFutureDate($weekDay->name);

        // Calculate event time slots based on week day configuration
        $timeSlot = $this->generateTimeSlot($weekDay);

        return [
            'classroom_id' => $classroom->id,
            'user_id' => $user->id,
            'weekday_id' => $weekDay->id,
            'title' => fake()->sentence(3),
            'date' => $date,
            'start_time' => $timeSlot['start'],
            'end_time' => $timeSlot['end'],
            'description' => fake()->paragraph(),
            'status' => fake()->randomElement(['scheduled', 'cancelled', 'completed'])
        ];
    }

    /**
     * Generate a future date that matches the given week day
     */
    private function generateFutureDate($dayName): string
    {
        $date = Carbon::now();

        // Add a random number of weeks (1-8) to ensure a future date
        $date->addWeeks(rand(1, 8));

        // Adjust to the desired day of the week
        while ($date->format('l') !== $dayName) {
            $date->addDay();
        }

        return $date->format('Y-m-d');
    }

    /**
     * Generate valid start and end times based on week day configuration
     */
    private function generateTimeSlot($weekDay)
    {
        // Extract only the time part in case the value includes a full datetime
        $startTime = Carbon::parse($weekDay->start_time)->format('H:i');
        $endTime = Carbon::parse($weekDay->end_time)->format('H:i');

        $startTime = Carbon::createFromFormat('H:i', $startTime);
        $endTime = Carbon::createFromFormat('H:i', $endTime);

        // Calculate available slots based on session duration
        $duration = $weekDay->session_duration;
        $availableSlots = [];

        while ($startTime->copy()->addMinutes($duration)->lte($endTime)) {
            $slotEnd = $startTime->copy()->addMinutes($duration);
            $availableSlots[] = [
                'start' => $startTime->format('H:i'),
                'end' => $slotEnd->format('H:i')
            ];
            $startTime->addMinutes($duration);
        }

        // Return a random time slot
        return fake()->randomElement($availableSlots);
    }

    /**
     * Configure the factory to always create scheduled events
     */
    public function scheduled(): EventFactory|Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => EventStatus::SCHEDULED->value,
            ];
        });
    }

    /**
     * Configure the factory to create events for a specific classroom
     */
    public function forClassroom(Classroom $classroom): EventFactory|Factory
    {
        return $this->state(function (array $attributes) use ($classroom) {
            return [
                'classroom_id' => $classroom->id
            ];
        });
    }

    /**
     * Configure the factory to create events for a specific user
     */
    public function forOrganizer(User $user): EventFactory|Factory
    {
        return $this->state(function (array $attributes) use ($user) {
            return [
                'user_id' => $user->id
            ];
        });
    }
}
