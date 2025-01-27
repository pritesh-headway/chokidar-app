<?php

namespace App\Http\Controllers;

use App\Models\Forum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ForumController extends Controller
{
    protected function addFullImageUrl($forum)
    {
        // For profile photo
        $forum->profile_photo = config('app.url') . '/public/storage/' . $forum->profile_photo;

        // For photos (if any)
        if (!empty($forum->photos)) {
            $photos = json_decode($forum->photos, true);
            $forum->photos = array_map(function ($photo) {
                return config('app.url') . '/public/storage/' . $photo;
            }, $photos);
        }

        return $forum;
    }



    // public function index(Request $request)
    // {
    //     $validated = $request->validate([
    //         'id' => 'nullable|integer'
    //     ]);

    //     $query = Forum::query();

    //     if (isset($validated['id']) && $validated['id'] !== 'all') {
    //         $query->where('id', $validated['id']);
    //     }

    //     $forums = $query->get();

    //     $forumsWithNo = $forums->map(function ($forum, $index) {
    //         $forum = $this->addFullImageUrl($forum);
    //         $forum->no = $index + 1; // Adding the "no" field
    //         return $forum;
    //     });

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Forums retrieved successfully.',
    //         'data' => $forumsWithNo
    //     ]);
    // }

    public function index(Request $request)
    {
        // Validate request parameters
        $validated = $request->validate([
            'id' => 'nullable|integer'
        ]);

        // Get the logged-in user's society_id
        $loggedInUser = auth()->user();
        $loggedInSocietyId = $loggedInUser->society_id;

        // Start building the query
        $query = Forum::query();

        if (isset($validated['id']) && $validated['id'] !== 'all') {
            $query->where('id', $validated['id']);
        }

        // Get all forums
        $forums = $query->get();

        // Filter forums by the logged-in user's society_id
        $forums = $forums->filter(function ($forum) use ($loggedInSocietyId) {
            // Fetch the society_id of the user who created the forum
            $userSocietyId = \App\Models\User::find($forum->user_id)->society_id;

            // Compare with the logged-in user's society_id
            return $userSocietyId === $loggedInSocietyId;
        });

        // Map forums to the desired response format with additional data
        $forumsWithNo = $forums->values()->map(function ($forum, $index) {
            // Add full URLs for images using your helper function
            $forum = $this->addFullImageUrl($forum);

            return [
                'id' => $forum->id,
                'block_number' => $forum->block_number,
                'user_id' => $forum->user_id,
                'forum_by' => $forum->forum_by,
                'title' => $forum->title,
                'description' => $forum->description,
                'date' => \Carbon\Carbon::parse($forum->date)->format('d-m-Y'),
                'profile_photo' => $forum->profile_photo,
                'responses' => $forum->responses_count,  // Assuming you have a responses count field
                'photos' => $forum->photos,  // Photos with full URLs
                'status' => $forum->status,
                'created_at' => $forum->created_at->toIso8601String(),
                'updated_at' => $forum->updated_at->toIso8601String(),
                'no' => $index + 1,  // Adding consistent 'no' index
            ];
        });
        return response()->json([
            'status' => true,
            'message' => 'Forums retrieved successfully.',
            'data' => $forumsWithNo
        ]);
    }


    public function show(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|integer'
        ]);

        $forum = Forum::find($validated['id']);

        if (!$forum) {
            return response()->json([
                'status' => false,
                'message' => 'Forum not found.',
                'data' => null
            ], 404);
        }

        $forum = $this->addFullImageUrl($forum);
        $forum->no = 1; // Since this is a single item, "no" is set to 1

        return response()->json([
            'status' => true,
            'message' => 'Forum retrieved successfully.',
            'data' => $forum
        ]);
    }
    // Store, update, and destroy methods remain the same as above,
    // but you should ensure `addFullImageUrl` is called before returning the response
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

        $forum = $this->addFullImageUrl($forum);

        return response()->json([
            'status' => true,
            'message' => 'Forum created successfully.',
            'data' => $forum
        ], 201);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|integer',
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

        $forum = Forum::find($validated['id']);
        if (!$forum) {
            return response()->json([
                'status' => false,
                'message' => 'Forum not found.',
                'data' => null
            ], 404);
        }

        $forum->update($validated);

        $forum = $this->addFullImageUrl($forum);

        return response()->json([
            'status' => true,
            'message' => 'Forum updated successfully.',
            'data' => $forum
        ]);
    }

    public function destroy(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|integer'
        ]);

        $forum = Forum::find($validated['id']);
        if (!$forum) {
            return response()->json([
                'status' => false,
                'message' => 'Forum not found.',
                'data' => null
            ], 404);
        }

        $forum->delete();

        return response()->json([
            'status' => true,
            'message' => 'Forum deleted successfully.',
            'data' => null
        ]);
    }
}
