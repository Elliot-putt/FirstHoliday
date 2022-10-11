<?php

namespace Database\Factories;

use App\Models\Flight;
use App\Models\Hotel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Package>
 */
class PackageFactory extends Factory {

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'flight_id' =>Flight::select('id')->orderByRaw("RAND()")->first()->id,
            'hotel_id' => Hotel::select('id')->orderByRaw("RAND()")->first()->id,
            'original_price' => $this->faker->numberBetween(1000, 2000),
            'discounted_price' => $this->faker->numberBetween(600, 1000),
        ];
    }

}
