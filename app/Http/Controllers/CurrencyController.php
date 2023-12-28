<?php

namespace App\Http\Controllers;
use App\Models\Currency;
use Illuminate\Http\Request;
use app\Http\Resources\CurrencyResource;
class CurrencyController extends Controller
{
    public function createCurrencies() {
        $currencies = json_decode(file_get_contents(storage_path('countries.json')), true);
        foreach ($currencies as $currency) {
            Currency::create([
                'currency_code' => $currency['currency'],
                'currency_name' => $currency['currency_name'],
                // Add other necessary data
            ]);
        }
        return response()->json('Countries imported successfully');
    }


    public function getCurrencies() {
        try {
            $currencies = Currency::all();
            return CurrencyResource::collection($currencies);
        } catch (\Exception $e) {
            return response()->json('Error retrieving countries', 500);
        }
    }
}
