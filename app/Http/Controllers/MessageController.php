<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index(Request $request)
    {

        $messages = Message::all();
        return response()->json([
            'status' => true,
            'message' => 'All messages retrieved successfully.',
            'data' => $messages
        ]);
    }
    public function show(Request $request)
    {

        $query = Message::query();
        if ($request->has('id')) {
            $query->where('id', $request->id);
        }

        if ($request->has('conversation_id')) {
            $query->where('conversation_id', $request->conversation_id);
        }

        if ($request->has('sender_id')) {
            $query->where('sender_id', $request->sender_id);
        }

        if ($request->has('receiver_id')) {
            $query->where('receiver_id', $request->receiver_id);
        }
        $messages = $query->get();
        return response()->json([
            'status' => true,
            'message' => 'Messages retrieved successfully.',
            'data' => $messages
        ]);
    }

    public function store(Request $request)
    {
        $missingParams = [];

        if (!$request->has('conversation_id')  || is_null($request->conversation_id)) {
            $missingParams[] = 'conversation_id';
        }
        if (!$request->has('sender_id')  || is_null($request->sender_id)) {
            $missingParams[] = 'sender_id';
        }
        if (!$request->has('receiver_id')  || is_null($request->receiver_id)) {
            $missingParams[] = 'receiver_id';
        }
        if (!$request->has('message')  || is_null($request->message)) {
            $missingParams[] = 'message';
        }
        if (count($missingParams) > 0) {
            return response()->json([
                'status' => false,
                'message' => 'Missing parameters.',
                'data' => $missingParams
            ], 200);
        }

        $data = $request->validate([
            'conversation_id' => 'required|exists:conversations,id',
            'sender_id' => 'required|exists:users,id',
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string',
            'is_read' => 'nullable|boolean',
        ]);

        $message = Message::create($data);
        return response()->json([
            'status' => true,
            'message' => 'Message created successfully.',
            'data' => $message
        ], 200);
    }

    public function update(Request $request)
    {
        $missingParams = [];
        if (!$request->has('id') || is_null($request->id)) {
            $missingParams[] = 'id';
        }
        if (count($missingParams) > 0) {
            return response()->json([
                'status' => false,
                'message' => 'Missing parameters.',
                'data' => $missingParams
            ], 200);
        }
        $data = $request->validate([
            'id' => 'required|exists:messages,id',
            'conversation_id' => 'sometimes|exists:conversations,id',
            'sender_id' => 'sometimes|exists:users,id',
            'receiver_id' => 'sometimes|exists:users,id',
            'message' => 'sometimes|string',
            'is_read' => 'sometimes|boolean',
        ]);
        $message = Message::findOrFail($data['id']);
        $message->update($data);
        return response()->json([
            'status' => true,
            'message' => 'Message updated successfully.',
            'data' => $message
        ]);
    }

    public function destroy(Request $request)
    {
        $missingParams = [];

        if (!$request->has('id')) {
            $missingParams[] = 'id';
        }
        if (count($missingParams) > 0) {
            return response()->json([
                'status' => false,
                'message' => 'Missing parameters.',
                'data' => $missingParams
            ], 200);
        }

        $data = $request->validate([
            'id' => 'required|exists:messages,id',
        ]);

        $message = Message::findOrFail($data['id']);
        $message->delete();
        return response()->json([
            'status' => true,
            'message' => 'Message deleted successfully.',
            'data' => $message
        ]);
    }
}
