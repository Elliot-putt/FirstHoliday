<?php

namespace App\Http\Controllers;

use App\Models\Airport;
use App\Models\Booking;
use App\Models\Country;
use App\Models\Flight;
use App\Models\Hotel;
use App\Models\Package;
use App\Models\Ticket;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;
use Carbon\Carbon;
use Illuminate\Http\Request;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Incoming\Answer;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class BotManController extends Controller {

    /**
     * Place your BotMan logic here.
     */

    public function handle()
    {

        //Initiate Chatbot
        $botman = app('botman');
        //Wait for message from user
        $botman->hears('{message}', function(BotMan $botman, $message) {
            //If the users message is "Hi"
            if(str_contains($message, 'hi') || str_contains($message, 'Hi') || str_contains($message, 'hello'))
            {
                if($botman->userStorage()->get('name'))
                {
                    $botman->typesAndWaits(1.5);
                    $botman->reply('Hi ' . $botman->userStorage()->get('name') . ' How can we help you?');
                } else
                {
                    $this->askName($botman);
                }
                //If the users message is "Holiday"
            } else if(str_contains($message, 'holiday') || str_contains($message, 'Holiday'))
            {
                $this->startHoliday($botman);
                //If the users message is "Package"
            } else if(str_contains($message, 'package') || str_contains($message, 'packages') || str_contains($message, 'Package'))
            {
                $botman->typesAndWaits(1.5);
                $botman->reply("To view all of our package holiday's click <a target='_blank' href='/packages'>here</a>! ");
                //If the users message is "Airport"
            } else if(str_contains($message, 'fly') || str_contains($message, 'Fly') || str_contains($message, 'list airports'))
            {
                $botman->typesAndWaits(1.5);
                $airports = Airport::query()->pluck('name')->toArray();
                $names = implode(', ', $airports);
                $botman->reply("To view all of our Airports we fly from click <a href='google.com'>here</a>!<br><br> {$names}. ");
                //If the users message is "Countries"
            } else if(str_contains($message, 'countries') || str_contains($message, 'country') || str_contains($message, 'Country'))
            {
                $botman->typesAndWaits(1.5);
                $countries = Country::query()->pluck('name')->toArray();
                $names = implode(', ', $countries);
                $botman->reply("To view all of our countries we travel to click <a href='google.com'>here</a>!<br><br> {$names}. ");
                //If the users message is "Cheapest"
            } else if(str_contains($message, 'hotels') || str_contains($message, 'offer') || str_contains($message, 'Hotels'))
            {
                $botman->typesAndWaits(1.5);
                $hotels = Hotel::query()->pluck('name')->toArray();
                $names = implode(', ', $hotels);
                $botman->reply("To view all of our countries we travel to click <a href='/hotels'>here</a>!<br><br> {$names}. ");
                //If the users message is "Cheapest"
            } else if(str_contains($message, 'cheapest') || str_contains($message, 'lowest') || str_contains($message, 'Cheapest'))
            {
                $botman->typesAndWaits(1.5);
                $cheapest = Package::query()->orderBy('discounted_price', 'asc')->first();
                $botman->reply("Looking for a bargin click here to view our cheapest package holiday <a href='google.com'>here</a>!");
                $botman->reply('Here is our cheapest Holiday. <br>Click here to find out more.<br> ' . "<a href='www.google.com'> {$cheapest->hotel->country->name} - {$cheapest->hotel->name} - £{$cheapest->discounted_price}. <br> <img class='img-thumbnail' src='https://loremflickr.com/g/190/140/paris'></a> ");
                $botman->reply('Not a fan of our choice click here to see all of our offer for your query selections.<br> ' . "<a href='www.google.com'>All {$cheapest->hotel->country->name} Holiday's</a>");
                //If the users message is "more help or ?"
            } else if(str_contains($message, 'more help') || $message == 'more help' || $message == 'More Help')
            {
                $botman->typesAndWaits(1.5);
                $botman->reply('Answer the question below to submit a ticket request from out team!');
                $this->createTicket($botman);
                //If the users message is "Help"
            } else if(str_contains($message, 'deals') && str_contains($message, 'airport') || str_contains($message, 'Deals') && str_contains($message, 'Airport'))
            {
                $botman->typesAndWaits(1.5);
                $this->airportDeal($botman);
                //If the users message is "Help"
            } else if(str_contains($message, 'deals') && str_contains($message, 'destination') || str_contains($message, 'Deals') && str_contains($message, 'Destination'))
            {
                $botman->typesAndWaits(1.5);
                $this->destinationDeal($botman);
                //If the users message is "Help"
            } else if(str_contains($message, 'deals') && str_contains($message, 'hotel') || str_contains($message, 'Deals') && str_contains($message, 'Hotel'))
            {
                $botman->typesAndWaits(1.5);
                $this->hotelDeal($botman);
                //If the users message is "Help"
            } else if(str_contains($message, 'book') && str_contains($message, 'getaway') || str_contains($message, 'Getaway') && str_contains($message, 'Book'))
            {
                //booking a holiday
                if($botman->userStorage()->get('package'))
                {
                    $this->bookPackage($botman);

                } else if($botman->userStorage()->get('hotel'))
                {
                    $this->bookHotel($botman);
                } else
                {
                    $botman->typesAndWaits(1.5);
                    $botman->reply('Have you tried our Holiday helper? Type one of these commands below to continue:');
                    $botman->reply('Deals for a desired Hotel?');
                    $botman->reply('Help with my Holiday?');
                }
                //If the users message is "Help"
            } else if(str_contains($message, 'deals') && str_contains($message, 'date') || str_contains($message, 'Deals') && str_contains($message, 'Date'))
            {
                $botman->typesAndWaits(1.5);
                $this->dateDeal($botman);
                //If the users message is "Help"
            } else if(str_contains($message, 'help') || str_contains($message, '?') || str_contains($message, 'Help'))
            {
                $botman->typesAndWaits(1.5);
                $botman->reply('Try some of these commands:');
                $botman->reply('Say Hi!');
                $botman->reply('Help with my Holiday?');
                $botman->reply('What is the cheapest break?');
                $botman->reply('What counties do we travel to?');
                $botman->reply('What hotels do we offer to?');
                $botman->reply('Where can i fly from?');
                $botman->reply('Deals for an Airport near me?');
                $botman->reply('Deals for a desired Destination?');
                $botman->reply('Deals for a desired Hotel?');
                $botman->reply('Deals for a desired Date I want to travel?');
                $botman->reply('Help me book a getaway!');
                $botman->reply('More Help!');
                //If the users message matches nothing then echo a list of commands
            } else
            {
                $botman->typesAndWaits(1.5);
                $botman->reply('Try some of these commands:');
                $botman->reply('Say Hi!');
                $botman->reply('Help with my Holiday?');
                $botman->reply('What is the cheapest break?');
                $botman->reply('What counties do we travel to?');
                $botman->reply('Where can i fly from?');
                $botman->reply('Deals for an Airport near me?');
                $botman->reply('Deals for a desired Destination?');
                $botman->reply('Deals for a desired Hotel?');
                $botman->reply('Deals for a desired Date I want to travel?');
                $botman->reply('Help me book a getaway!');
                $botman->reply('More Help!');
            }

        });

        $botman->listen();

    }

    /**
     * Place your BotMan logic here.
     */

    public function askName(BotMan $botman)
    {

        $botman->typesAndWaits(1.5);
        $botman->ask('Hello! What is your Name?', function(Answer $answer) use ($botman) {
            $name = $answer->getText();
            $botman->userStorage()->save(['name' => $name]);

            $this->say('Nice to meet you ' . $botman->userStorage()->get('name') . ' How can we help you?');
        });

    }

    public function createTicket(BotMan $botman)
    {
        $botman->typesAndWaits(1.5);
        //ask first question and wait for a reply
        $botman->ask('What is your email?', function(Answer $answer, $bot) use ($botman) {

            $email = $answer->getText();
            $botman->userStorage()->save(['email' => $email]);
            $this->say("Email:{$email}");
            //ask second question and wait for a reply
            $bot->ask('What is your question for the team?', function(Answer $answer) use ($botman) {

                $question = $answer->getText();
                $ticket = Str::random(5);
                $this->say("Thank You , your ticket reference is #{$ticket}. We will be in touch shortly.");
                //create ticket
                Ticket::create([
                    'email' => $botman->userStorage()->get('email'),
                    'ref' => $ticket,
                    'message' => $question,
                ]);
            });
        });

    }

    public function bookHotel(BotMan $botman)
    {
        $hotel = Hotel::whereId($botman->userStorage()->get('hotel'))->first();
        $botman->reply("Here is a link to package holidays to " . $hotel->name . " - £" . $hotel->price_per_night . " Per Night " . " <br><a target='_blank'  href='/hotel/{$hotel->id}'>Click here to find out more<br> " . "<br> <img class='img-thumbnail' src='https://loremflickr.com/g/190/140/brazil'></a> ");

        $question = Question::create('Would you like to book this hotel?')
            ->fallback('Unable to book hotel')
            ->callbackId('create_hotel')
            ->addButtons([
                Button::create('Of course')->value('yes'),
                Button::create('No thanks!')->value('no'),
            ]);
        $botman->ask($question, function(Answer $answer, $bot) use ($botman) {
            // Detect if button was clicked:
            if($answer->isInteractiveMessageReply())
            {
                $selectedValue = $answer->getValue(); // will be either 'yes' or 'no'
                $selectedText = $answer->getText(); // will be either 'Of course' or 'Hell no!'

            }
            if($selectedValue == 'yes')
            {
                $bot->ask('What is your email?', function(Answer $answer, $bot) use ($botman) {
                    $answer = $answer->getText();

                    Booking::create([
                        'hotel_id' => $botman->userStorage()->get('hotel'),
                        'email' => $answer,
                        'date_booked' => Carbon::now(),
                    ]);
                    $this->say('Great this is all booked!');
                });
            } else
            {
                $this->say("No problem we'll be waiting");

            }
        });
    }

    public function bookPackage(BotMan $botman)
    {
        $cheapest = Package::whereId($botman->userStorage()->get('package'))->first();
        $botman->reply('Here is your selected Holiday. <br>Click here to find out more.<br> ' . "<a target='_blank' href='/packages/{$cheapest->id}'> {$cheapest->hotel->country->name} - {$cheapest->hotel->name} - £{$cheapest->discounted_price}. <br> <img class='img-thumbnail' src='https://loremflickr.com/g/190/140/paris'></a> ");

        $question = Question::create('Would you like to book this holiday?')
            ->fallback('Unable to book Holiday')
            ->callbackId('create_holiday')
            ->addButtons([
                Button::create('Of course')->value('yes'),
                Button::create('No thanks!')->value('no'),
            ]);
        $botman->ask($question, function(Answer $answer, $bot) use ($botman) {
            // Detect if button was clicked:
            if($answer->isInteractiveMessageReply())
            {
                $selectedValue = $answer->getValue(); // will be either 'yes' or 'no'
                $selectedText = $answer->getText(); // will be either 'Of course' or 'Hell no!'

            }
            if($selectedValue == 'yes')
            {
                $bot->ask('What is your email?', function(Answer $answer, $bot) use ($botman) {
                    $answer = $answer->getText();

                    Booking::create([
                        'package_id' => $botman->userStorage()->get('package'),
                        'email' => $answer,
                        'date_booked' => Carbon::now(),
                    ]);
                    $this->say('Great this is all booked!');
                });
            } else
            {
                $this->say("No problem we'll be waiting");

            }
        });
    }

    public function airportDeal(BotMan $botman)
    {
        $botman->ask('What airport would you like to fly from?', function(Answer $answer, $bot) use ($botman) {

            $airport = $answer->getText();
            $foundAirport = Airport::query()->where('name', 'LIKE', '%' . $airport . '%')->first();
            //do where query where answer is like airport name
            if($foundAirport)
            {
                $flights = Flight::whereId('departure_airport_id', $foundAirport->id)->get()->pluck('id')->toArray();
                $package = Package::query()->whereIn('flight_id', $flights)->orderBy('discounted_price', 'asc');
                $implode = implode(",", $package->pluck('id')->toArray());
                $this->say('Great we have found the airport <strong>' . $foundAirport->name . '</strong>.');
                $this->say("Here is a link to holidays from " . $foundAirport->name . ". <br><a target='_blank'  href='/package/filter?packages={$implode}'>Click here to find out more.<br> " . " <br> <img class='img-thumbnail' src='https://loremflickr.com/g/190/140/brazil'></a> ");
            } else
            {
                $this->say("Oops. We can't find " . $airport . " in our selection list of airports please try again!");
                $this->repeat();
            }

        });
    }

    public function destinationDeal(BotMan $botman)
    {
        $botman->ask('What Country would you like to fly to?', function(Answer $answer, $bot) use ($botman) {

            $destination = $answer->getText();
            //make sure it's not the same airport
            $foundCountry = Country::query()->where('name', 'LIKE', '%' . $destination . '%')->first();
            //do where query where answer is like airport name
            if($foundCountry)
            {
                $flightsTo = $foundCountry->airports()->get()->pluck('id')->toArray();
                $flights = Flight::whereIn('departure_airport_id', $flightsTo)->get()->pluck('id')->toArray();
                $package = Package::query()->whereIn('flight_id', $flights)->orderBy('discounted_price', 'asc');
                $implode = implode(",", $package->pluck('id')->toArray());
                $this->say('Great We have found the country  <strong>' . $foundCountry->name . ' </strong>.');
                $this->say("Here is a link to holidays to " . $foundCountry->name . " " . " <br><a target='_blank'  href='/package/filter?packages={$implode}'>Click here to find out more<br> " . "<br> <img class='img-thumbnail' src='https://loremflickr.com/g/190/140/brazil'></a> ");

            } else
            {
                $this->say("Oops. We can't find " . $destination . " in our selection list of destination's please try again!");
                $this->repeat();
            }

        });
    }

    public function hotelDeal(BotMan $botman)
    {
        $botman->ask('What is the name of the hotel you would like book?', function(Answer $answer, $bot) use ($botman) {

            $hotel = $answer->getText();
            //make sure it's not the same airport
            $foundHotel = Hotel::query()->where('name', 'LIKE', '%' . $hotel . '%')->first();
            //do where query where answer is like airport name
            if($foundHotel)
            {
                $botman->userStorage()->save(['hotel' => $foundHotel->id]);
                $flightsTo = $foundHotel->country->airports()->get()->pluck('id')->toArray();
                $flights = Flight::whereIn('departure_airport_id', $flightsTo)->get()->pluck('id')->toArray();
                $package = Package::query()->whereIn('flight_id', $flights)->orderBy('discounted_price', 'asc');
                $implode = implode(",", $package->pluck('id')->toArray());
                $this->say('Great We have found the hotel  <strong>' . $foundHotel->name . '</strong>.');
                if($package)
                {
                    $this->say("Here is a link to package holidays to " . $foundHotel->name . " - £" . $foundHotel->price_per_night . " Per Night " . " <br><a target='_blank'  href='/package/filter?packages={$implode}'>Click here to find out more<br> " . "<br> <img class='img-thumbnail' src='https://loremflickr.com/g/190/140/brazil'></a> ");
                    $this->say("Else here is a link to our offer for without flights " . $foundHotel->name . " " . " <br><a target='_blank'  href='/hotels/{$foundHotel->id}'>Click here to find out more<br> " . "<br> <img class='img-thumbnail' src='https://loremflickr.com/g/190/140/brazil'></a> ");

                } else
                {
                    $this->say("Here is a link to our offer for " . $foundHotel->name . " " . " <br><a target='_blank'  href='/hotels/{$foundHotel->id}'>Click here to find out more<br> " . "<br> <img class='img-thumbnail' src='https://loremflickr.com/g/190/140/brazil'></a> ");

                }

            } else
            {
                $this->say("Oops. We can't find " . $hotel . " in our selection list of destination's please try again!");
                $this->repeat();
            }

        });
    }

    public function dateDeal(BotMan $botman)
    {
        $botman->ask('What month would you like to fly?', function(Answer $answer, $bot) use ($botman) {

            $months = Collection::empty();
            $period = Carbon::now()->subYear();

            for($i = 0; $i < 12; $i++)
            {
                $months->push($period->format('F'));
                $period->addMonth();
            }

            $month = ucfirst($answer->getText());

            //do where query where answer is like airport name
            if($months->filter(function($item) use ($month) {
                return str_contains($item, $month);
            }))
            {
                $botman->userStorage()->save(['month' => $month]);
                $this->say('We have selected  <strong>' . $month . ' </strong>.');
                $bot->ask('What year would you like to fly?', function(Answer $answer, $bot) use ($botman) {

                    $years = Collection::empty();
                    $period = Carbon::now()->subYear();

                    for($i = 0; $i < 10; $i++)
                    {
                        $years->push($period->format('Y'));
                        $period->addYear();
                    }
                    $yearInput = str_replace(' ', '', $answer->getText());
                    $input = null;
                    foreach($years as $year)
                    {
                        if($year === $yearInput)
                        {
                            $input = $year;
                        }
                    }
                    //do where query where answer is like airport name
                    if($input)
                    {
                        $month = $botman->userStorage()->get('month');
                        $year = $yearInput;
                        $monthCarbon = Carbon::parse("28 {$month}")->month;
                        $date = Carbon::parse("{$year}-{$monthCarbon}-28")->addMonth();
                        $flights = Flight::where('departure_time', '>=', $date)->get()->pluck('id')->toArray();
                        $package = Package::query()->whereIn('flight_id', $flights)->orderBy('discounted_price', 'asc');
                        $implode = implode(",", $package->pluck('id')->toArray());
                        $this->say('You have selected ' . $yearInput . '.');
                        $this->say("Here is a link to holidays in " . $month . " " . $year . ". <br><a  target='_blank'  href='/package/filter?packages={$implode}'>Click here to find out more.<a/><br> " . "<a href='www.google.com'> <br> <img class='img-thumbnail' src='https://loremflickr.com/g/190/140/brazil'></a> ");


                    } else
                    {
                        $this->say("Oops. This date is incorrect or too far in advance!");
                        $this->repeat();
                    }
                });
            } else
            {
                $this->say("Oops. We can't find " . $month . " in our selection list of months please try again!");
                $this->repeat();
            }
        });
    }

    public function startHoliday(BotMan $botman)
    {
        $botman->typesAndWaits(1.5);
        $botman->reply('It Looks like you need Holiday help...');

        $this->askDetails($botman);
    }

    public function askDetails(BotMan $botman)
    {
        //ask airport from
        $botman->ask('What airport would you like to fly from?', function(Answer $answer, $bot) use ($botman) {

            $airport = $answer->getText();
            $foundAirport = Airport::query()->where('name', 'LIKE', '%' . $airport . '%')->first();
            //do where query where answer is like airport name
            if($foundAirport)
            {
                $botman->userStorage()->save(['airportFrom' => $foundAirport->id]);
                $botman->userStorage()->save(['airportFromName' => $foundAirport->name]);
                $this->say('Great we have found the airport <strong>' . $foundAirport->name . '</strong>.');
                //ask country
                $bot->ask('What Country would you like to fly to?', function(Answer $answer, $bot) use ($botman) {

                    $destination = $answer->getText();
                    //make sure it's not the same airport
                    $foundCountry = Country::query()->where('name', 'LIKE', '%' . $destination . '%')->first();
                    //do where query where answer is like airport name
                    if($foundCountry)
                    {
                        $botman->userStorage()->save(['country' => $foundCountry->id]);
                        $botman->userStorage()->save(['countryName' => $foundCountry->name]);

                        $this->say('Great We have found the country  <strong>' . $foundCountry->name . ' </strong>.');
                        $bot->ask('What month would you like to fly?', function(Answer $answer, $bot) use ($botman) {

                            $months = Collection::empty();
                            $period = Carbon::now()->subYear();

                            for($i = 0; $i < 12; $i++)
                            {
                                $months->push($period->format('F'));
                                $period->addMonth();
                            }

                            $month = ucfirst($answer->getText());

                            //do where query where answer is like airport name
                            if($months->filter(function($item) use ($month) {
                                return str_contains($item, $month);
                            }))
                            {
                                $botman->userStorage()->save(['month' => $month]);
                                $this->say('We have selected  <strong>' . $month . ' </strong>.');
                                $bot->ask('What year would you like to fly?', function(Answer $answer, $bot) use ($botman) {

                                    $years = Collection::empty();
                                    $period = Carbon::now()->subYear();

                                    for($i = 0; $i < 10; $i++)
                                    {
                                        $years->push($period->format('Y'));
                                        $period->addYear();
                                    }
                                    $yearInput = str_replace(' ', '', $answer->getText());
                                    $input = null;
                                    foreach($years as $year)
                                    {
                                        if($year === $yearInput)
                                        {
                                            $input = $year;
                                        }
                                    }
                                    //do where query where answer is like airport name
                                    if($input)
                                    {
                                        $botman->userStorage()->save(['year' => $yearInput]);
                                        $countryName = $botman->userStorage()->get('countryName');
                                        $airport = $botman->userStorage()->get('airportFromName');
                                        $airportId = $botman->userStorage()->get('airportFrom');
                                        $countryId = $botman->userStorage()->get('country');
                                        $month = $botman->userStorage()->get('month');
                                        $year = $yearInput;
                                        $month = Carbon::parse("28 {$month}")->month;
                                        $date = Carbon::parse("{$year}-{$month}-28")->addMonth();
                                        $flightsFrom = Airport::whereId($airportId)->get()->pluck('id')->toArray();
                                        $country = \App\Models\Country::where('id', '=', $countryId)->first();
                                        $flightsTo = $country->airports()->get()->pluck('id')->toArray();
                                        $flights = Flight::whereIn('departure_airport_id', $flightsFrom)->whereIn('arrival_airport_id', $flightsTo)->where('departure_time', '>=', $date)->get()->pluck('id')->toArray();
                                        $hotels = Hotel::where('country_id', '=', $country->id)->get()->pluck('id')->toArray();
                                        $countryPackage = Package::whereIn('hotel_id', $hotels)->get()->pluck('id')->toArray();
                                        $package = Package::query()->whereIn('flight_id', $flights)->orderBy('discounted_price', 'asc');
                                        $cheapest = $package->first();
                                        $botman->userStorage()->save(['package' => $cheapest->id]);
                                        $implode = implode(",", $countryPackage);
                                        if($implode == "")
                                        {
                                            $implode = implode(",", $package->pluck('id')->toArray());
                                        }

                                        $this->say('You have selected ' . $yearInput . '.');
                                        if($cheapest)
                                        {
                                            $this->say('Here is our selected Holiday. <br>Click here to find out more.<br> ' . "<a target='_blank' href='/packages/{$cheapest->id}'> {$countryName} - {$cheapest->hotel->name} - £{$cheapest->discounted_price}. <br> <img class='img-thumbnail' src='https://loremflickr.com/g/190/140/paris'></a> ");
                                            $this->say('Not a fan of our choice?  Click here to see all of our offer for your query selections.<br> ' . "<a target='_blank' href='/package/filter?packages={$implode}'>All {$countryName} Holiday's</a>");

                                        } else
                                        {
                                            $this->say('There are no holidays for you selected details , click here to see all of our offer for your query selections.<br> ' . "<a target='_blank' href='/package/filter?packages={$implode}'>All {$countryName} Holiday's</a>");
                                        }
                                    } else
                                    {
                                        $this->say("Oops. This date is incorrect or too far in advance!");
                                        $this->repeat();
                                    }
                                });
                            } else
                            {
                                $this->say("Oops. We can't find " . $month . " in our selection list of months please try again!");
                                $this->repeat();
                            }
                        });
                    } else
                    {
                        $this->say("Oops. We can't find " . $destination . " in our selection list of destination's please try again!");
                        $this->repeat();
                    }
                });
            } else
            {
                $this->say("Oops. We can't find " . $airport . " in our selection list of airports please try again!");
                $this->repeat();
            }
        });

    }

}
