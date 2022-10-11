<?php

namespace Database\Factories;

use App\Models\Airport;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Flight>
 */
class FlightFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'ref' => $this->faker->uuid,
            'departure_airport_id' => Airport::select('id')->orderByRaw("RAND()")->first()->id,
            'arrival_airport_id' => Airport::select('id')->orderByRaw("RAND()")->first()->id,
            'departure_time' => $this->faker->dateTimeThisYear,
            'arrival_time' => $this->faker->dateTimeThisYear,
            'passenger_amount' => $this->faker->numberBetween(1 , 300),
        ];
    }
}
