<?php

namespace Database\Factories;

use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Hotel>
 */
class HotelFactory extends Factory {

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'img' => $this->faker->imageUrl,
            'name' => $this->faker->company,
            'country_id' => Country::select('id')->orderByRaw("RAND()")->first()->id,
            'address' => $this->faker->address,
            'postcode' => $this->faker->postcode,
            'rating' => $this->faker->numberBetween(0, 5),
        ];
    }

}
