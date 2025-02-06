<?php

namespace App\Http\Controllers;

use App\Models\User;
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
                'society_id' => \App\Models\User::find($forum->user_id)->society_id,
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

    public function getAllInactiveForums(Request $request)
    {
        $request->merge(['status' => 'deactive']);
        return $this->show($request);
    }

    public function getAllActiveForums(Request $request)
    {
        $request->merge(['status' => 'active']);
        return $this->show($request);
    }


    public function show(Request $request)
    {
        $validated = $request->validate([
            'id' => 'nullable|integer',
            'status' => 'nullable|in:active,deactive'
        ]);

        $loggedInUser = auth()->user();
        $loggedInSocietyId = $loggedInUser->society_id;

        // If 'id' is provided, return the specific forum
        if (!empty($validated['id'])) {
            $forum = Forum::find($validated['id']);

            if (!$forum) {
                return response()->json([
                    'status' => false,
                    'message' => 'Forum not found.',
                    'data' => null
                ], 404);
            }

            // Ensure the forum belongs to the logged-in user's society
            if (\App\Models\User::find($forum->user_id)->society_id !== $loggedInSocietyId) {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthorized access to this forum.',
                    'data' => null
                ], 403);
            }

            $forum = $this->addFullImageUrl($forum);
            $forum->no = 1; // Since this is a single item, "no" is set to 1

            return response()->json([
                'status' => true,
                'message' => 'Forum retrieved successfully.',
                'data' => $forum
            ]);
        }

        // If 'status' is provided, return all forums with that status
        if (!empty($validated['status'])) {
            $forums = Forum::where('status', $validated['status'])
                ->orderBy('created_at', 'desc')
                ->get()
                ->filter(function ($forum) use ($loggedInSocietyId) {
                    return \App\Models\User::find($forum->user_id)->society_id === $loggedInSocietyId;
                })
                ->values()
                ->map(function ($forum, $index) {
                    $forum = $this->addFullImageUrl($forum);
                    return [
                        'id' => $forum->id,
                        'society_id' => \App\Models\User::find($forum->user_id)->society_id,
                        'block_number' => $forum->block_number,
                        'user_id' => $forum->user_id,
                        'forum_by' => $forum->forum_by,
                        'title' => $forum->title,
                        'description' => $forum->description,
                        'date' => \Carbon\Carbon::parse($forum->date)->format('d-m-Y'),
                        'profile_photo' => $forum->profile_photo,
                        'responses' => $forum->responses_count,
                        'photos' => $forum->photos,
                        'status' => $forum->status,
                        'created_at' => $forum->created_at->toIso8601String(),
                        'updated_at' => $forum->updated_at->toIso8601String(),
                        'no' => $index + 1,
                    ];
                });

            return response()->json([
                'status' => true,
                'message' => "Forums with status '{$validated['status']}' retrieved successfully.",
                'data' => $forums
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Please provide either an id or a status.',
            'data' => null
        ], 400);
    }

    // Store, update, and destroy methods remain the same as above,
    // but you should ensure `addFullImageUrl` is called before returning the response
    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'block_number' => 'required|string|max:50',
    //         'forum_by' => 'required|string|max:50',
    //         'title' => 'required|string|max:255',
    //         'description' => 'required|string',
    //         'date' => 'required|date',
    //         'profile_photo' => 'required|string|max:256',
    //         'responses' => 'nullable|integer',
    //         'photos' => 'nullable|array',
    //         'status' => 'nullable|in:active,deactive',
    //     ]);

    //     $forum = Forum::create($validated);

    //     $forum = $this->addFullImageUrl($forum);

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Forum created successfully.',
    //         'data' => $forum
    //     ], 201);
    // }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id', // Ensure user_id exists
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'responses' => 'nullable|integer',
            'photos' => 'nullable',
            'status' => 'nullable|in:active,deactive',
        ]);

        // Fetch the user details using user_id
        $user = User::findOrFail($validated['user_id']);

        // Store the profile photo and other images
        // $profilePhotoUrl = $this->storeFileInPublicFolder($request->file('profile_photo'), 'forum_images');

        $photos = [];
        if ($request->hasFile('photos')) {
            if (is_array($request->file('photos'))) {
                foreach ($request->file('photos') as $photo) {
                    $photoPath = $this->storeFileInPublicFolder($photo, 'forum_images');
                    $photos[] = $photoPath;
                }
            } else {
                $photoPath = $this->storeFileInPublicFolder($request->file('photos'), 'forum_images');
                $photos[] = $photoPath;
            }
        }

        // Prepare the forum data
        $forumData = [
            'user_id' => $validated['user_id'],
            'block_number' => $user->block_number,
            'forum_by' => $user->first_name . ' ' . $user->last_name,
            'title' => $validated['title'],
            'description' => $validated['description'],
            'date' => $validated['date'],
            'profile_photo' => $user->profile_photo,
            'photos' => json_encode($photos), // Store multiple photos as JSON
            'responses' => 0, // Default response count, will be updated later
            'status' => $validated['status'] ?? 'active', // Set default status to active if not provided
        ];

        // Create the forum entry
        $forum = Forum::create($forumData);

        // Add full URL for profile photo and photos
        $forum = $this->addFullImageUrl($forum);

        return response()->json([
            'status' => true,
            'message' => 'Forum created successfully.',
            'data' => $forum
        ], 201);
    }

    protected function storeFileInPublicFolder($file, $folder)
    {
        // Generate a unique file name
        $filename = time() . '_' . $file->getClientOriginalName();
        $filename = str_replace(' ', '_', $filename);
        // Move the file to the desired folder in public/storage
        $file->move(public_path("storage/{$folder}"), $filename);

        // Return the relative path to the file
        return "{$folder}/{$filename}";
    }


    // public function update(Request $request)
    // {
    //     $validated = $request->validate([
    //         'id' => 'required|integer',
    //         'block_number' => 'nullable|string|max:50',
    //         'forum_by' => 'nullable|string|max:50',
    //         'title' => 'nullable|string|max:255',
    //         'description' => 'nullable|string',
    //         'date' => 'nullable|date',
    //         'profile_photo' => 'nullable|string|max:256',
    //         'responses' => 'nullable|integer',
    //         'photos' => 'nullable|array',
    //         'status' => 'nullable|in:active,deactive',
    //     ]);

    //     $forum = Forum::find($validated['id']);
    //     if (!$forum) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Forum not found.',
    //             'data' => null
    //         ], 404);
    //     }

    //     $forum->update($validated);

    //     $forum = $this->addFullImageUrl($forum);

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Forum updated successfully.',
    //         'data' => $forum
    //     ]);
    // }



    public function update(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|integer|exists:forums,id', // Ensure forum exists
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'date' => 'nullable|date',
            'responses' => 'nullable|integer',
            'photos' => 'nullable',
            'status' => 'nullable|in:active,deactive',
        ]);

        // Fetch the forum to update
        $forum = Forum::find($validated['id']);
        if (!$forum) {
            return response()->json([
                'status' => false,
                'message' => 'Forum not found.',
                'data' => null
            ], 404);
        }

        // Fetch the user details using user_id from the forum
        $user = User::findOrFail($forum->user_id);

        // Prepare the forum data for update
        $forumData = [
            'title' => $validated['title'] ?? $forum->title,
            'description' => $validated['description'] ?? $forum->description,
            'date' => $validated['date'] ??  \Carbon\Carbon::parse($forum->date)->format('Y-m-d'),

            'block_number' => $user->block_number, // Fetch block_number from the user
            'forum_by' => $user->first_name . ' ' . $user->last_name, // Concatenate first and last name
            'status' => $validated['status'] ?? $forum->status, // Keep the current status if not provided
        ];

        // Handle photos (multiple or single)
        if ($request->hasFile('photos')) {
            $photos = [];
            // dd($request->file('photos'));
            if (is_array($request->file('photos'))) {
                foreach ($request->file('photos') as $photo) {
                    $photoPath = $this->storeFileInPublicFolder($photo, 'forum_images');
                    $photos[] = $photoPath;
                }
            } else {
                $photoPath = $this->storeFileInPublicFolder($request->file('photos'), 'forum_images');
                $photos[] = $photoPath;
            }
            $forumData['photos'] = json_encode($photos); // Store photos as JSON
        }

        // Update the forum with the new data
        $forum->update($forumData);

        // Add full URL for the photos
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
            'id' => 'required|integer|exists:forums,id', // Ensure the forum exists
        ]);

        // Fetch the forum to delete
        $forum = Forum::find($validated['id']);
        if (!$forum) {
            return response()->json([
                'status' => false,
                'message' => 'Forum not found.',
                'data' => null
            ], 404);
        }

        // Optionally, delete the associated responses if needed
        // Forum::find($validated['id'])->responses()->delete(); // Uncomment if you want to delete responses

        // Delete the forum record
        $forum->delete();

        return response()->json([
            'status' => true,
            'message' => 'Forum deleted successfully.',
            'data' => null // No need to return anything in the data, as it's deleted
        ]);
    }
}
