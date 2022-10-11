<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FlightController extends Controller {

    public function index()
    {
        return Inertia::render('Flights/View', [
            'flights' => \App\Models\Flight::query()
                ->when(\Illuminate\Support\Facades\Request::input('search'), function($query, $search) {
                    $query->where('ref', 'like', "%{$search}%");
                })
                ->paginate(10)
                ->withQueryString()->through(fn($flight) => [
                    'id' => $flight->id,
                    'ref' => $flight->ref,
                    'departureAirport' => $flight->departureAirport->name,
                    'arrivalAirport' => $flight->arrivalAirport->name,
                    'departureDate' => Carbon::parse($flight->departure_time)->format('d-m-Y'),
                    'arrivalDate' => Carbon::parse($flight->arrival_time)->format('d-m-Y'),
                    'seats' => $flight->passenger_amount,
                    'date' => Carbon::parse($flight->created_at)->format('d-m-Y'),
                    'departureCountry' => $flight->departureAirport->country->name,
                    'ArrivalCountry' => $flight->arrivalAirport->country->name,
                ]),
            'filters' => \Illuminate\Support\Facades\Request::only(['search']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Flight $flight
     * @return \Illuminate\Http\Response
     */
    public function show(Flight $flight)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Flight $flight
     * @return \Illuminate\Http\Response
     */
    public function edit(Flight $flight)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Flight       $flight
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Flight $flight)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Flight $flight
     * @return \Illuminate\Http\Response
     */
    public function destroy(Flight $flight)
    {
        //
    }

}
