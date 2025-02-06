<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function index()
    {
        return response()->json([
            'status' => true,
            'message' => 'this is admin dashboard response.',

        ], 201);
    }
}
