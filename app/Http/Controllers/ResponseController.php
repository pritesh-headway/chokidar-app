<?php

// app/Http/Controllers/ResponseController.php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Forum;
use App\Models\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ResponseController extends Controller
{
    // app/Http/Controllers/ResponseController.php

    public function index(Request $request)
    {
        $responses = Response::all();  // Get all responses from the database

        return response()->json([
            'status' => true,
            'message' => 'All responses retrieved successfully',
            'data' => $responses,
        ], 200);
    }


    // app/Http/Controllers/ResponseController.php

    public function show(Request $request)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'id' => 'nullable|exists:responses,id',
            'forum_id' => 'nullable|exists:forums,id',
            'user_id' => 'nullable|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'data' => $validator->errors(),
            ], 200);
        }

        // Start with the base query for responses
        $query = Response::query();

        // Apply filters based on provided parameters
        if ($request->has('id') && $request->id != null) {
            $query->where('id', $request->id);
        }

        if ($request->has('forum_id') && $request->forum_id != null) {
            $query->where('forum_id', $request->forum_id);
        }

        if ($request->has('user_id') && $request->user_id != null) {
            $query->where('user_id', $request->user_id);
        }

        // Execute the query
        $responses = $query->get();

        if ($responses->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'No responses found based on the given criteria.',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Responses retrieved successfully',
            'data' => $responses,
        ], 200);
    }


    // Store: Create a new response
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'forum_id' => 'required|exists:forums,id',
            'user_id' => 'required|exists:users,id',
            'status' => 'nullable|in:active,deactive',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'data' => $validator->errors(),
            ], 200);
        }

        // Check if a response with the same forum_id and user_id already exists
        $existingResponse = Response::where('forum_id', $request->forum_id)
            ->where('user_id', $request->user_id)
            ->first();

        if ($existingResponse) {
            return response()->json([
                'status' => false,
                'message' => 'Response already exists for this forum and user.',
                'data' => null,
            ], 400);
        }

        $response = Response::create([
            'forum_id' => $request->forum_id,
            'user_id' => $request->user_id,
            'status' => $request->status ?? "active",
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Response created successfully',
            'data' => $response,
        ], 200);
    }

    // Update: Update a response
    public function update(Request $request)
    {
        // dd($request);
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:responses,id',
            'status' => 'required|in:active,deactive',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'data' => $validator->errors(),
            ], 200);
        }

        $response = Response::find($request->id);
        $response->update([
            'status' => $request->status,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Response updated successfully',
            'data' => $response,
        ], 200);
    }

    // Delete: Delete a response
    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:responses,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'data' => $validator->errors(),
            ], 200);
        }

        $response = Response::find($request->id);
        $response->delete();

        return response()->json([
            'status' => true,
            'message' => 'Response deleted successfully',
        ], 200);
    }
}