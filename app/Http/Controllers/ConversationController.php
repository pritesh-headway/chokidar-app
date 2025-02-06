<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
    public function index(Request $request)
    {

        $conversations = Conversation::all();

        return response()->json([
            'status' => true,
            'message' => 'All Conversations retrieved successfully.',
            'data' => $conversations
        ]);
    }

    public function show(Request $request)
    {

        $request->validate([
            'id' => 'sometimes|exists:conversations,id',
            'sender_id' => 'sometimes|exists:users,id',
            'receiver_id' => 'sometimes|exists:users,id',
        ]);
        $query = Conversation::query();
        if ($request->has('id')) {
            $query->where('id', $request->input('id'));
        }
        if ($request->has('sender_id')) {
            $query->where('sender_id', $request->input('sender_id'));
        }
        if ($request->has('receiver_id')) {
            $query->where('receiver_id', $request->input('receiver_id'));
        }
        $conversations = $query->get();
        return response()->json([
            'status' => true,
            'message' => 'Particular Conversations retrieved successfully.',
            'data' => $conversations
        ]);
    }
    public function store(Request $request)
    {

        $data = $request->only(['sender_id', 'receiver_id', 'status']);

        $missingParams = [];
        if (!$request->has('sender_id') || is_null($request->sender_id)) {
            $missingParams[] = 'sender_id';
        }

        if (!$request->has('receiver_id') || is_null($request->receiver_id)) {
            $missingParams[] = 'receiver_id';
        }

        if (!$request->has('status') || is_null($request->status)) {
            $missingParams[] = 'status';
        }
        if (!empty($missingParams)) {
            return response()->json([
                'status' => false,
                'message' => 'Some parameters are missing.',
                'data' => [
                    'missing_parameters' => $missingParams
                ]
            ], 200);
        }
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

        return response()->json([
            'status' => true,
            'message' => 'Conversation updated successfully.',
            'data' => $conversation
        ]);
    }

    public function destroy(Request $request)
    {

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

        return response()->json([
            'status' => true,
            'message' => 'Conversation deleted successfully.',
            'data' => $conversation
        ]);
    }
}
