<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flights', function(Blueprint $table) {
            $table->id();
            $table->longText('ref');
            $table->foreignId('departure_airport_id');
            $table->foreignId('arrival_airport_id');
            $table->dateTime('departure_time');
            $table->dateTime('arrival_time');
            $table->integer('passenger_amount')->default(255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('flights');
    }

};
