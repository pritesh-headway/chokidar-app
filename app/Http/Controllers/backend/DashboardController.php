<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;


class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->check()) {
            return redirect('/');
        }

        $user = auth()->user();

        if ($user->role_id == 1) { // Check if user is an admin (role_id = 1)
            // Retrieve all users and current user data directly
            $data = User::all(); // Fetch all users
            $currentUserData = User::find($user->id); // Fetch current user by ID
            return view('dashboard.dashboard', ['data' => $data, 'current' => $currentUserData]);
        } else {
            abort(404); // Forbidden access for non-admin users
        }
    }

    public function deleteUser($userID)
    {
        $user = User::find($userID);
        if (!$user) {
            return redirect('/dashboard')->with('response', ['status' => 404, 'message' => "User not found!"]);
        }

        $data = $user->delete();
        if ($data) {
            return redirect('/dashboard')->with('response', ['status' => 200, 'message' => "User deleted successfully!"]);
        } else {
            return redirect('/dashboard')->with('response', ['status' => 400, 'message' => "Something went wrong!"]);
        }
    }
}
