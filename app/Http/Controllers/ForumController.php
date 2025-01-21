<?php


namespace App\Http\Controllers;

use App\Models\Forum;
use Illuminate\Http\Request;

class ForumController extends Controller
{
    // Display a listing of forums or by user block_number if provided
    public function index(Request $request)
    {
        $query = Forum::query();

        if ($request->has('id') && $request->id !== 'all') {
            $query->where('id', $request->id);
        }

        $forums = $query->get();
        return response()->json($forums);
    }

    // Display a specific forum post
    public function show($id)
    {
        $forum = Forum::find($id);

        if (!$forum) {
            return response()->json(['message' => 'Forum not found'], 404);
        }

        return response()->json($forum);
    }

    // Store a new forum post
    public function store(Request $request)
    {
        $validated = $request->validate([
            'block_number' => 'required|string|max:50',
            'forum_by' => 'required|string|max:50',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'profile_photo' => 'required|string|max:256',
            'responses' => 'nullable|integer',
            'photos' => 'nullable|array',
            'status' => 'nullable|in:active,deactive',
        ]);

        $forum = Forum::create($validated);

        return response()->json(['message' => 'Forum created successfully.', 'data' => $forum], 201);
    }

    // Update an existing forum post
    public function update(Request $request, $id)
    {
        $forum = Forum::find($id);
        if (!$forum) {
            return response()->json(['message' => 'Forum not found'], 404);
        }

        $validated = $request->validate([
            'block_number' => 'nullable|string|max:50',
            'forum_by' => 'nullable|string|max:50',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'date' => 'nullable|date',
            'profile_photo' => 'nullable|string|max:256',
            'responses' => 'nullable|integer',
            'photos' => 'nullable|array',
            'status' => 'nullable|in:active,deactive',
        ]);

        $forum->update($validated);

        return response()->json(['message' => 'Forum updated successfully.', 'data' => $forum]);
    }

    // Delete a forum post
    public function destroy($id)
    {
        $forum = Forum::find($id);
        if (!$forum) {
            return response()->json(['message' => 'Forum not found'], 404);
        }

        $forum->delete();

        return response()->json(['message' => 'Forum deleted successfully.']);
    }
}
