<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class SuperAdminController extends Controller
{

    // public function __construct()
    // {
    //     // Applying middleware to the entire controller
    //     $this->middleware('auth:api');
    //     $this->middleware('role:super-admin');
    // }

    public function index()
    {
        // dd(auth()->user()->can('create post'));
        // dd(auth()->user()->id);

        return response()->json([
            'status' => true,
            'message' => 'this is super admin dashboard response.',
            // 'user' => $user,
        ], 201);
    }
}
