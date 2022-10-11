<?php

namespace Database\Seeders;

use App\Models\Airport;
use App\Models\Country;
use App\Models\Hotel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder {

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(1)->create();
//        \App\Models\Country::factory(10)->create();
        \App\Models\Airport::factory(10)->create();
        \App\Models\Flight::factory(2000)->create();
//        \App\Models\Hotel::factory(10)->create();
        \App\Models\Ticket::factory(10)->create();
        \App\Models\Package::factory(1000)->create();
        for($i = 0; $i < 100; $i++)
        {
            DB::table('airport_countries')->insert(
                [
                    'airport_id' => Airport::select('id')->orderByRaw("RAND()")->first()->id,
                    'country_id' => Country::select('id')->orderByRaw("RAND()")->first()->id,
                ]
            );
        }
        for($i = 0; $i < 100; $i++)
        {
            DB::table('country_hotels')->insert(
                [
                    'hotel_id' => Hotel::select('id')->orderByRaw("RAND()")->first()->id,
                    'country_id' => Country::select('id')->orderByRaw("RAND()")->first()->id,
                ]
            );
        }

    }

}
