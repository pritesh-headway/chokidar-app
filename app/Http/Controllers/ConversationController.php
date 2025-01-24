<?php
// app/Http/Controllers/ConversationController.php

namespace App\Http\Controllers;

use App\Models\Conversation;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
    public function index(Request $request)
    {
        // Optionally handle pagination or filtering via request body if needed
        $conversations = Conversation::all();
        // return response()->json($conversations);
        return response()->json([
            'status' => true,
            'message' => 'All Conversations retrieved successfully.',
            'data' => $conversations
        ]);
    }

    public function show(Request $request)
    {
        // Validate incoming request data
        $request->validate([
            'id' => 'sometimes|exists:conversations,id',
            'sender_id' => 'sometimes|exists:users,id',
            'receiver_id' => 'sometimes|exists:users,id',
        ]);

        // Start building the query
        $query = Conversation::query();


        // Check if 'id' is provided in the input body
        if ($request->has('id')) {
            $query->where('id', $request->input('id')); // Use input() to fetch the body data
        }

        // Check if 'sender_id' is provided in the input body
        if ($request->has('sender_id')) {
            $query->where('sender_id', $request->input('sender_id'));
        }

        // Check if 'receiver_id' is provided in the input body
        if ($request->has('receiver_id')) {
            $query->where('receiver_id', $request->input('receiver_id'));
        }

        // Execute the query and retrieve the conversations
        $conversations = $query->get();

        // Return the response with a success message and data
        return response()->json([
            'status' => true,
            'message' => 'Particular Conversations retrieved successfully.',
            'data' => $conversations
        ]);
    }
    public function store(Request $request)
    {
        // Validate incoming request data, but do not require parameters
        $data = $request->only(['sender_id', 'receiver_id', 'status']);

        $missingParams = [];

        // Manually check for missing parameters or null values
        if (!$request->has('sender_id') || is_null($request->sender_id)) {
            $missingParams[] = 'sender_id';
        }

        if (!$request->has('receiver_id') || is_null($request->receiver_id)) {
            $missingParams[] = 'receiver_id';
        }

        if (!$request->has('status') || is_null($request->status)) {
            $missingParams[] = 'status';
        }

        // If any parameters are missing, return 200 status with missing parameters
        if (!empty($missingParams)) {
            return response()->json([
                'status' => false,
                'message' => 'Some parameters are missing.',
                'data' => [
                    'missing_parameters' => $missingParams
                ]
            ], 200);
        }

        // Proceed with creating the conversation if no parameters are missing
        $conversation = Conversation::create($data);

        return response()->json([
            'status' => true,
            'message' => 'Created Conversation successfully.',
            'data' => $conversation
        ], 200);
    }


    public function update(Request $request)
    {
        $data = $request->validate([
            'id' => 'sometimes|exists:conversations,id',
            'sender_id' => 'sometimes|exists:users,id',
            'receiver_id' => 'sometimes|exists:users,id',
            'status' => 'sometimes|in:active,deactive',
        ]);



        if (!$request->has('id')) {
            return response()->json([
                'status' => false,
                'message' => 'ID parameter is required.',
                'data' => []
            ], 200);
        }



        $conversation = Conversation::findOrFail($data['id']);
        $conversation->update($data);
        // return response()->json($conversation);
        return response()->json([
            'status' => true,
            'message' => 'Conversation updated successfully.',
            'data' => $conversation
        ]);
    }

    public function destroy(Request $request)
    {
        // dd($request->id);
        $request->validate([
            'id' => 'nullable|exists:conversations,id',
        ]);
        if (empty($request->id)) {
            return response()->json([
                'status' => false,
                'message' => 'Conversation delete failed.',
                'data' => "Id is required"
            ], 200);
        }


        $conversation = Conversation::findOrFail($request->id);
        $conversation->delete();
        // return response()->json(['message' => 'Conversation deleted successfully']);
        return response()->json([
            'status' => true,
            'message' => 'Conversation deleted successfully.',
            'data' => $conversation
        ]);
    }
}
