<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index(){
        $accounts = Account::all();
         return view('accounts.index', compact('accounts'));
    }
    function accountValidation(Request $request){
       return $request->validate([
            'balance' => 'required|decimal',
            'account_name'=>'required|string|max:255',
            'account_type' => 'required|in:savings,checking,credit',
            'currency_id' => 'required|integer',
            'customer_id' => 'required|integer',

        ]);
    }
    public function accountCreate(Request $request){
        Account::create(AccountController::accountValidation($request));
        return redirect()->route('accounts.index')->with('success', 'Account created successfully!');
    }

    public function accountUpdate(Request $request, $accountId){
            $account = Account::findOrFail($accountId);
            if($request->filled('account_name')){
                $account->account_name = ProfileController::profileValidation($request);
            }
            $account->save();
            return redirect()->route('accounts.index')->with('success', 'Account updated successfully!');
    }

    public function accountDestroy($accountId){
        if (!auth()->user()->can('delete', Account::find($accountId))) {
            return abort(403, 'Unauthorized access.');
        }

        Account::find($accountId)->delete();

        // permanently delete the profile:
        // Profile::find($profileId)->forceDelete();

        return redirect()->route('profiles.index')->with('success', 'Account deleted successfully!');
    }
}
