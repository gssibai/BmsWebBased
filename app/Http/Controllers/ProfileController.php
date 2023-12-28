<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $profiles = Profile::all();
        return view('profiles.index', compact('profiles'));
    }

     function profileValidation(Request $request){
         return $request->validate([
             'first_name' => 'required|string|max:255',
             'last_name' => 'required|string|max:255',
             'address' => 'required|string',
             'phone_no' => 'required|string|max:20',
             'email' => 'required|email|unique:profiles',
             'city_id' => 'required|integer',
             'permission' => 'required|string|in:customer,employer,manager',
             'status' => 'required|string|in:active,disabled,blocked',
             'passport_no' => 'unique:profiles',
             'password' => 'required|confirmed|min:8',
         ]);
    }
    public function profileCreate(Request $request){
        Profile::create(ProfileController::profileValidation($request));
         return redirect()->route('profile.index')->with('success' , 'Profile created successfully');
    }

    public function profileUpdate(Request $request, $profileId) {
        $profile = Profile::findOrFail($profileId);
        $fields = ['first_name','last_name', 'address', 'phone_no', 'email', 'city_id', 'permission', 'status', 'passport_no', 'password' ];

        foreach($fields as $field){
            if($request->filled($field)){
                $profile->$field = ProfileController::profileValidation($request);
            }
        }
        $profile->save();
        return redirect()->route('profiles.index')->with('success', 'Profile updated successfully!');
    }

    public function destroy($profileId)
{
    if (!auth()->user()->can('delete', Profile::find($profileId))) {
        return abort(403, 'Unauthorized access.');
    }

    Profile::find($profileId)->delete();

    // permanently delete the profile:
    // Profile::find($profileId)->forceDelete();

    return redirect()->route('profiles.index')->with('success', 'Profile deleted successfully!');
}
}
