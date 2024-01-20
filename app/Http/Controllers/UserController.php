<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Hash;
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
public function editUsers(Request $request) {
    $userIds = $request->input('userIds');
    if (!$userIds) {
        // Redirect back when no users are selected
        return redirect()->back()->with('error', 'Please select at least one user to update.');
    }
    $selectedUsers = User::whereIn('id', explode(',', $userIds))->get();

    // Return the update page with selected users
    return view('update_users')->with('users', $selectedUsers);
}

public function updateUsersData(Request $request) {
    $usersData = $request->input('usersData');

    foreach ($usersData as $userId => $data) {
        $user = User::find($userId);
        $user->name = $data['name'];
        $user->email = $data['email'];
       // $user->password = Hash::make($data['password']);
        $user->save();
    }
    return redirect()->route('user-management')->with('success','');
}
public function deleteSelected(Request $request) {
    $selectedUserIds = explode(',', $request->input('selectedUsers'));

    // Perform deletion based on the selected user IDs
    User::whereIn('id', $selectedUserIds)->delete();

    return redirect()->back()->with('success', 'Selected users deleted successfully');
}


public function deleteAllExceptLoggedIn()
{
    $loggedInUserId = Auth::id();

    // Delete all users except the logged-in user
    User::where('id', '!=', $loggedInUserId)->delete();

    return redirect()->back()->with('success', 'All users except the logged-in user have been deleted!');
}
}
