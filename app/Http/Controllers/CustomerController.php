<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all(); // Modify based on your needs
        return view('customers.index', compact('customers'));
    }
    function customerValidation(Request $request){
        return $request->validate([
            'account_id' => 'required|integer',
            'profile_id' => 'required|integer',
        ]);
    }
    public function customerCreate(Request $request){
        Customer::create(CustomerController::customerValidation($request));
        return redirect()->route('customers.index')->with('success', 'Customer created successfully!');

    }

    public function destroy(Request $request, $customerId){
        if (!auth()->user()->can('delete', Customer::find($customerId))) {
            return abort(403, 'Unauthorized access.');
        }
        Customer::find($customerId)->delete();

        // permanently delete the profile:
        // Profile::find($profileId)->forceDelete();

        return redirect()->route('profiles.index')->with('success', 'Customer deleted successfully!');
    }
}
