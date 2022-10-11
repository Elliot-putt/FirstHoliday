<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Package;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PackageController extends Controller {

    public function index()
    {
        return Inertia::render('Packages/View', [
            'packages' => \App\Models\Package::query()
                ->when(\Illuminate\Support\Facades\Request::input('search'), function($query, $search) {
                    $hotel = Hotel::where('name', 'LIKE', '%' . $search . '%')->get()->pluck('id')->toArray();
                    $query->whereIn('hotel_id', $hotel);
                })
                ->paginate(5)
                ->withQueryString()->through(fn($package) => [
                    'id' => $package->id,
                    'hotel' => $package->hotel->name,
                    'departureAirport' => $package->flight->departureAirport->name,
                    'arrivalAirport' => $package->flight->arrivalAirport->name,
                    'originalPrice' => $package->original_price,
                    'discountedPrice' => $package->discounted_price,
                    'departureDate' => Carbon::parse($package->flight->departure_time)->format('d-m-Y'),
                    'arrivalDate' => Carbon::parse($package->arrival_time)->format('d-m-Y'),
                    'departureCountry' => $package->flight->departureAirport->country->name,
                    'ArrivalCountry' => $package->flight->arrivalAirport->country->name,
                ]),
            'filters' => \Illuminate\Support\Facades\Request::only(['search']),
        ]);
    }

    public function filter()
    {

        return Inertia::render('Packages/View', [
            'packages' => Package::query()
                ->when(\Illuminate\Support\Facades\Request::input('search'), function($query, $search) {
                    $hotel = Hotel::where('name', 'LIKE', '%' . $search . '%')->get()->pluck('id')->toArray();
                    $query->whereIn('hotel_id', $hotel);
                })
                ->when(\Illuminate\Support\Facades\Request::input('packages'), function($query, $search) {
                    $ids = explode(',', \request('packages'));

                    $query->whereIn('id', $ids);
                })
                ->paginate(5)
                ->withQueryString()->through(fn($package) => [
                    'id' => $package->id,
                    'hotel' => $package->hotel->name,
                    'departureAirport' => $package->flight->departureAirport->name,
                    'arrivalAirport' => $package->flight->arrivalAirport->name,
                    'originalPrice' => $package->original_price,
                    'discountedPrice' => $package->discounted_price,
                    'departureDate' => Carbon::parse($package->flight->departure_time)->format('d-m-Y'),
                    'arrivalDate' => Carbon::parse($package->arrival_time)->format('d-m-Y'),
                    'departureCountry' => $package->flight->departureAirport->country->name,
                    'ArrivalCountry' => $package->flight->arrivalAirport->country->name,
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

    public function show(Package $package)
    {
        return Inertia::render('Packages/Show', [
            'pack' => $package
                ->fill([
                    'id' => $package->id,
                    'hotel' => $package->hotel->name,
                    'departureAirport' => $package->flight->departureAirport->name,
                    'arrivalAirport' => $package->flight->arrivalAirport->name,
                    'originalPrice' => $package->original_price,
                    'discountedPrice' => $package->discounted_price,
                    'departureDate' => Carbon::parse($package->flight->departure_time)->format('d-m-Y'),
                    'arrivalDate' => Carbon::parse($package->arrival_time)->format('d-m-Y'),
                    'departureCountry' => $package->flight->departureAirport->country->name,
                    'ArrivalCountry' => $package->flight->arrivalAirport->country->name,
                ]),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Package $package
     * @return \Illuminate\Http\Response
     */
    public function edit(Package $package)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Package      $package
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Package $package)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Package $package
     * @return \Illuminate\Http\Response
     */
    public function destroy(Package $package)
    {
        //
    }

}
