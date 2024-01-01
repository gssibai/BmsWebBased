<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all(); // Fetch all users from the database

        // Pass the $users data to the view
        return view('laravel-examples/user-management', ['users' => $users]);
    }

    public function delete($id)
{
    $user = User::find($id);
    $loggedInUserId = Auth::id();
    
    if (!$user) {
        // Handle if user is not found
        return redirect()->back()->with('error', 'User not found!');
    }
   if($id == $loggedInUserId) {
    return redirect()->back()->with('error', 'You cannot delete the logged in user');
   }
   $user->delete();
   return redirect()->back()->with('success', 'User deleted successfully!');
}

public function deleteAllExceptLoggedIn()
{
    $loggedInUserId = Auth::id();

    // Delete all users except the logged-in user
    User::where('id', '!=', $loggedInUserId)->delete();

    return redirect()->back()->with('success', 'All users except the logged-in user have been deleted!');
}
}
