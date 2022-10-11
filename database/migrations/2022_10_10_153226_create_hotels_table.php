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
        Schema::create('hotels', function(Blueprint $table) {
            $table->id();
            $table->longText('img')->nullable();
            $table->longText('name');
            $table->foreignId('city_id')->nullable();
            $table->foreignId('country_id');
            $table->text('address')->nullable();
            $table->text('postcode')->nullable();
            $table->integer('rating');
            $table->text('category')->nullable();
            $table->integer('price_per_night');
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
        Schema::dropIfExists('hotels');
    }

};
