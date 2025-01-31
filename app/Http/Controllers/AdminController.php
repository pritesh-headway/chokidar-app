<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function index()
    {
        // dd(auth()->user()->id);
        // dd(auth()->user()->id);
        // $user = User::find(247);
        // dd($user->getRoleNames());  // Should return a collection containing 'super-admin'

        // dd(auth()->user()->hasRole('admin'));

        return response()->json([
            'status' => true,
            'message' => 'this is admin dashboard response.',
            // 'user' => $user,
        ], 201);
    }
}
