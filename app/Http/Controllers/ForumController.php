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

        $forum->profile_photo = config('app.url') . '/public/storage/' . $forum->profile_photo;
        if (!empty($forum->photos)) {
            $photos = json_decode($forum->photos, true);
            $forum->photos = array_map(function ($photo) {
                return config('app.url') . '/public/storage/' . $photo;
            }, $photos);
        }

        return $forum;
    }
    public function index(Request $request)
    {

        $validated = $request->validate([
            'id' => 'nullable|integer'
        ]);
        $loggedInUser = auth()->user();
        $loggedInSocietyId = $loggedInUser->society_id;
        $query = Forum::query();

        if (isset($validated['id']) && $validated['id'] !== 'all') {
            $query->where('id', $validated['id']);
        }
        $forums = $query->get();
        $forums = $forums->filter(function ($forum) use ($loggedInSocietyId) {

            $userSocietyId = \App\Models\User::find($forum->user_id)->society_id;
            return $userSocietyId === $loggedInSocietyId;
        });
        $forumsWithNo = $forums->values()->map(function ($forum, $index) {

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
        if (!empty($validated['id'])) {
            $forum = Forum::find($validated['id']);

            if (!$forum) {
                return response()->json([
                    'status' => false,
                    'message' => 'Forum not found.',
                    'data' => null
                ], 404);
            }
            if (\App\Models\User::find($forum->user_id)->society_id !== $loggedInSocietyId) {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthorized access to this forum.',
                    'data' => null
                ], 403);
            }

            $forum = $this->addFullImageUrl($forum);
            $forum->no = 1;

            return response()->json([
                'status' => true,
                'message' => 'Forum retrieved successfully.',
                'data' => $forum
            ]);
        }
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
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'responses' => 'nullable|integer',
            'photos' => 'nullable',
            'status' => 'nullable|in:active,deactive',
        ]);
        $user = User::findOrFail($validated['user_id']);
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
        $forumData = [
            'user_id' => $validated['user_id'],
            'block_number' => $user->block_number,
            'forum_by' => $user->first_name . ' ' . $user->last_name,
            'title' => $validated['title'],
            'description' => $validated['description'],
            'date' => $validated['date'],
            'profile_photo' => $user->profile_photo,
            'photos' => json_encode($photos),
            'responses' => 0,
            'status' => $validated['status'] ?? 'active',
        ];
        $forum = Forum::create($forumData);
        $forum = $this->addFullImageUrl($forum);

        return response()->json([
            'status' => true,
            'message' => 'Forum created successfully.',
            'data' => $forum
        ], 201);
    }

    protected function storeFileInPublicFolder($file, $folder)
    {

        $filename = time() . '_' . $file->getClientOriginalName();
        $filename = str_replace(' ', '_', $filename);

        $file->move(public_path("storage/{$folder}"), $filename);
        return "{$folder}/{$filename}";
    }
    public function update(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|integer|exists:forums,id',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'date' => 'nullable|date',
            'responses' => 'nullable|integer',
            'photos' => 'nullable',
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
        $user = User::findOrFail($forum->user_id);
        $forumData = [
            'title' => $validated['title'] ?? $forum->title,
            'description' => $validated['description'] ?? $forum->description,
            'date' => $validated['date'] ??  \Carbon\Carbon::parse($forum->date)->format('Y-m-d'),

            'block_number' => $user->block_number,
            'forum_by' => $user->first_name . ' ' . $user->last_name,
            'status' => $validated['status'] ?? $forum->status,
        ];
        if ($request->hasFile('photos')) {
            $photos = [];

            if (is_array($request->file('photos'))) {
                foreach ($request->file('photos') as $photo) {
                    $photoPath = $this->storeFileInPublicFolder($photo, 'forum_images');
                    $photos[] = $photoPath;
                }
            } else {
                $photoPath = $this->storeFileInPublicFolder($request->file('photos'), 'forum_images');
                $photos[] = $photoPath;
            }
            $forumData['photos'] = json_encode($photos);
        }
        $forum->update($forumData);
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
            'id' => 'required|integer|exists:forums,id',
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
