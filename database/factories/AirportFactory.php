<?php

namespace Database\Factories;

use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Airport>
 */
class AirportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'code' => $this->faker->countryCode,
            'name' => $this->faker->unique()->streetName . ' Airport',
//            'name' => $this->faker->unique()->randomElement(['Birmingham Airport' , 'East Midlands Airport' , 'Luton Airport' , 'Norwich Airport' , 'Stansted Airport' , 'Heathrow Airport' , 'Manchester Airport' , 'Gatwick Airport' , 'Barcelona–El Prat Airport'  , 'Bilbao Airport' , 'Burgos Airport' , 'Lleida-Alguaire Airport' , 'Beja Airport' , 'Santa Cruz Airport']),
            'country_id' => Country::select('id')->orderByRaw("RAND()")->first()->id,
            'postcode' => $this->faker->postcode,
            'address' => $this->faker->address,
        ];
    }
}
