<?php

namespace App\Http\Controllers;

use App\Models\Response;
use Illuminate\Http\Request;

class ResponseController extends Controller
{
    // Fetch all responses or filter by forum_id
    public function index(Request $request)
    {
        $forumId = $request->query('forum_id');
        if ($forumId) {
            $responses = Response::where('forum_id', $forumId)->get();
        } else {
            $responses = Response::all();
        }

        return response()->json($responses);
    }

    // Show a specific response
    public function show($id)
    {
        $response = Response::find($id);
        if (!$response) {
            return response()->json(['message' => 'Response not found'], 404);
        }

        return response()->json($response);
    }

    // Store a new response
    public function store(Request $request)
    {
        $request->validate([
            'forum_id' => 'required|exists:forums,id',  // Make sure the forum exists
            'user_name' => 'required|string|max:255',
            'comment' => 'required|string',
        ]);

        $response = Response::create([
            'forum_id' => $request->forum_id,
            'user_name' => $request->user_name,
            'comment' => $request->comment,
        ]);

        return response()->json(['message' => 'Response created successfully', 'data' => $response], 201);
    }

    // Update a response
    public function update(Request $request, $id)
    {
        $response = Response::find($id);
        if (!$response) {
            return response()->json(['message' => 'Response not found'], 404);
        }

        $request->validate([
            'user_name' => 'nullable|string|max:255',
            'comment' => 'nullable|string',
        ]);

        $response->update($request->only(['user_name', 'comment']));

        return response()->json(['message' => 'Response updated successfully', 'data' => $response]);
    }

    // Delete a response
    public function destroy($id)
    {
        $response = Response::find($id);
        if (!$response) {
            return response()->json(['message' => 'Response not found'], 404);
        }

        $response->delete();

        return response()->json(['message' => 'Response deleted successfully']);
    }
}
