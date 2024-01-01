<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use File;
class LocationController extends Controller
{
    /** Creating functions */
    // public function createCountries() {
    //     try {
    //         $countriesJson = File::get(storage_path('app/countries.json'));
    //         $countries = json_decode($countriesJson, true);

    //         foreach ($countries as $country) {
    //             Country::create([
    //                 'country_code' => $country['country_code'],
    //                 'country_name' => $country['country_name'],
    //                 // Add other necessary data
    //             ]);
    //         }

    //         return response()->json('Countries imported successfully');
    //     } catch (\Exception $e) {
    //         return $e;
    //     }
    // }


    public function createStates() {
        $states = json_decode(file_get_contents(storage_path('states.json')), true);
        foreach ($states as $state) {
            State::create([
                'state_code' => $state['state_code'],
                'state_name' => $state['state_name'],
                'country_id' => $state['country_id'],
                // Add other necessary data
            ]);
        }
        return response()->json('States imported successfully');
    }


    public function createCities() {
        $cities = json_decode(file_get_contents(storage_path('cities.json')), true);
        foreach ($cities as $city) {
            City::create([
                'city_name' => $city['name'],
                'state_id' => $city['state_id'],
                // Add other necessary data
            ]);
        }
        return response()->json('Cities imported successfully');
    }

    /** Retrieving functions */

    // public function getCountries() {
    //     try {
    //         $countries = Country::all();
    //         return CountryResource::collection($countries);
    //     } catch (\Exception $e) {
    //         return response()->json('Error retrieving countries', 500);
    //     }
    // }

    public function getCountries() {
        try {
            $countries = Country::orderBy('country_name', 'asc')->get();
            return view('auth.register', compact('countries')); // Pass sorted countries to the register view
        } catch (\Exception $e) {
            return response()->json('Error retrieving countries', 500);
        }
    }
    public function getStates() {
        try {
            $states = State::with('country')->get();
            return StateResource::collection($states);
        } catch (\Exception $e) {
            return response()->json('Error retrieving states', 500);
        }
    }

    public function getCities() {
        try {
            $cities = City::with('state')->get();
            return CityResource::collection($cities);
        } catch (\Exception $e) {
            return response()->json('Error retrieving cities', 500);
        }
    }

}
