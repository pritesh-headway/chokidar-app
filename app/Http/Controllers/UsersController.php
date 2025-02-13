<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Society;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->input('id');
        $society_id = $request->input('society_id', auth()->user()->society_id);

        if (!$id) {
            return response()->json([
                'status' => false,
                'message' => 'Missing required key: id',
                'data' => []
            ], 400);
        }

        $currentUser = auth()->user();
        if (!in_array($currentUser->role_id, [1, 2, 3, 4])) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized access',
                'data' => []
            ], 403);
        }
        $usersQuery = User::query()
            ->whereIn('role_id', [3, 4])
            ->where('status', 'active');
        if ($society_id) {
            $society = Society::find($society_id);
            if (!$society) {
                return response()->json([
                    'status' => false,
                    'message' => 'Society not found',
                    'data' => []
                ], 404);
            }
            $usersQuery->where('society_id', $society_id);
        }
        if ($id === 'all') {
            $users = $usersQuery->get()->groupBy('house.block');

            $users = $users->sortKeys();

            $data = [];

            foreach ($users as $blockTitle => $usersInBlock) {
                $blockData = [
                    'title' => $blockTitle,
                    'society_id' => $society_id,
                    'rows' => []
                ];

                foreach ($usersInBlock as $index => $user) {
                    $block = $user->house ? $user->house->block : null;
                    $house_no = $user->house ? $user->house->house_no : null;
                    $blockNumber = $block && $house_no ? $block . '-' . $house_no : null;
                    $blockData['rows'][] = [
                        'no' => $index + 1,
                        'id' => $user->id,
                        'block' => $block,
                        'house_no' => $house_no,
                        'blockNumber' => $blockNumber,
                        'image' => asset('storage/' . $user->profile_photo),
                        'ownerName' => $user->first_name . ' ' . $user->last_name,
                        'role_id' => $user->role_id,
                        'status' => $user->status,
                        'mobile' => $user->mobile,
                        'totalMembers' => $this->familyMemberCount($user->id),
                        'society_id' => $user->society_id ?? null,
                        'email' => $user->email,
                        'created_at' =>  \Carbon\Carbon::parse($user->created_at)->format('Y-m-d'),
                        'email_verified_at' => $user->email_verified_at,
                    ];
                }

                $data[] = $blockData;
            }

            return response()->json([
                'status' => true,
                'message' => 'Users fetched successfully',
                'data' => $data
            ]);
        }
        $user = $usersQuery->find($id);
        if ($user) {
            $block = $user->house ? $user->house->block : null;
            $house_no = $user->house ? $user->house->house_no : null;
            $blockNumber = $block && $house_no ? $block . '-' . $house_no : null;
            return response()->json([
                'status' => true,
                'message' => 'User fetched successfully',
                'data' => [
                    'society_id' => $user->society_id ?? null,
                    'user' => $user,
                    'block' => $block,
                    'house_no' => $house_no,
                    'blockNumber' => $blockNumber
                ]
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'User not found',
            'data' => []
        ], 404);
    }

    public function inactiveUsers(Request $request)
    {
        $id = $request->input('id');
        $society_id = $request->input('society_id', auth()->user()->society_id);

        if (!$id) {
            return response()->json([
                'status' => false,
                'message' => 'Missing required key: id',
                'data' => []
            ], 400);
        }

        $currentUser = auth()->user();
        if (!in_array($currentUser->role_id, [1, 2, 3, 4])) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized access',
                'data' => []
            ], 403);
        }
        $usersQuery = User::where('status', 'inactive')
            ->whereIn('role_id', [3, 4]);
        if ($society_id) {
            $society = Society::find($society_id);
            if (!$society) {
                return response()->json([
                    'status' => false,
                    'message' => 'Society not found',
                    'data' => []
                ], 404);
            }
            $usersQuery->where('society_id', $society_id);
        }
        if ($id === 'all') {
            $users = $usersQuery->get()->groupBy('house.block')->sortKeys();

            $data = [];

            foreach ($users as $blockTitle => $usersInBlock) {
                $blockData = [
                    'title' => $blockTitle,
                    'society_id' => $society_id,
                    'rows' => []
                ];

                foreach ($usersInBlock as $index => $user) {
                    $block = $user->house ? $user->house->block : null;
                    $house_no = $user->house ? $user->house->house_no : null;
                    $blockNumber = $block && $house_no ? $block . '-' . $house_no : null;
                    $blockData['rows'][] = [
                        'no' => $index + 1,
                        'id' => $user->id,
                        'block' => $block,
                        'house_no' => $house_no,
                        'blockNumber' => $blockNumber,
                        'image' => $user->profile_photo ? asset('storage/' . $user->profile_photo) : 'default_image_url',
                        'ownerName' => $user->first_name . ' ' . $user->last_name,
                        'role_id' => $user->role_id,
                        'status' => $user->status,
                        'mobile' => $user->mobile,
                        'totalMembers' => $this->familyMemberCount($user->id),
                        'society_id' => $user->society_id ?? null,
                        'email' => $user->email,
                        'created_at' =>  \Carbon\Carbon::parse($user->created_at)->format('Y-m-d'),
                        'email_verified_at' => $user->email_verified_at,
                    ];
                }

                $data[] = $blockData;
            }

            return response()->json([
                'status' => true,
                'message' => 'Inactive users fetched successfully',
                'data' => $data
            ]);
        }
        $user = $usersQuery->find($id);
        if ($user) {
            $block = $user->house ? $user->house->block : null;
            $house_no = $user->house ? $user->house->house_no : null;
            $blockNumber = $block && $house_no ? $block . '-' . $house_no : null;
            return response()->json([
                'status' => true,
                'message' => 'User fetched successfully',
                'data' => [
                    'society_id' => $user->society_id ?? null,
                    'user' => $user,
                    'block' => $block,
                    'house_no' => $house_no,
                    'blockNumber' => $blockNumber
                ]
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'User not found',
            'data' => []
        ], 404);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $loggedInUser = auth()->user();
        if (!in_array($loggedInUser->role_id, [1, 2])) {
            return response()->json([
                'status' => false,
                'message' => 'Only super-admin or admin can create users'
            ], 403);
        }
        // dd($request);
        // $validatedData = $request->validate([
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'mobile' => 'required',
            'profile_photo' => 'required|image',
            'email' => 'nullable|email',
            'house_id' => 'required|exists:houses,id',
            'status' => 'required|in:active,inactive',
            'role_id' => 'required|in:3,4',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors(),
            ], 422);
        }
        $validatedData = $validator->validated();
        $validatedData['society_id'] = $loggedInUser->society_id;
        $validatedData['profile_photo'] = $this->storeFileInPublicFolder($request->file('profile_photo'), 'profile_photos');
        if ($request->filled('password')) {
            $validatedData['password'] = bcrypt($request->password);
        }
        $validatedData['role_id'] = (int)$validatedData['role_id'];
        try {
            $user = User::create($validatedData);
            return response()->json([
                'status' => true,
                'message' => 'User created successfully',
                'data' => $user
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error creating user: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);

            return response()->json([
                'status' => false,
                'message' => 'Internal Server Error'
            ], 500);
        }
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
        $id = $request->input('id');
        if (!$id) {
            return response()->json(['status' => false, 'message' => 'Missing required key: id'], 400);
        }

        $user = User::find($id);
        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User not found'], 404);
        }

        if ($request->has('status')) {
            if ($request->input('status') == 'inactive') {
                $user->deleted_at = now();
            }
        }
        $authUser = auth()->user();
        if ($authUser->id !== $user->id && $authUser->role_id !== 1 && $authUser->role_id !== 2) {
            return response()->json(['status' => false, 'message' => 'You are not authorized to update this user'], 403);
        }
        if ($authUser->role_id === 2 && $authUser->society_id !== $user->society_id) {
            return response()->json(['status' => false, 'message' => 'You can only update users in your own society'], 403);
        }
        $validatedData = $request->validate([
            'first_name' => 'sometimes|required|string|max:50',
            'last_name' => 'sometimes|required|string|max:50',
            'role_id' => 'sometimes|required|exists:roles,id',
            'mobile' => 'sometimes|required|string|size:10',
            'house_id' => 'sometimes|required|exists:houses,id',
            'profile_photo' => 'nullable|image|max:2048',
            'status' => 'sometimes|required|in:active,inactive',
            'email' => 'sometimes|nullable|email',
            'password' => 'nullable|string|min:6',
        ]);
        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');
            $filename = str_replace(' ', '_', $file->getClientOriginalName());

            $fileName = time() . '_' . $filename;
            $destinationPath = public_path('storage/profile_photos');
            $file->move($destinationPath, $fileName);
            $validatedData['profile_photo'] = 'profile_photos/' . $fileName;
        }
        if ($request->filled('password')) {
            $validatedData['password'] = Hash::make($request->password);
        }

        $user->update($validatedData);

        return response()->json([
            'status' => true,
            'message' => 'User updated successfully',
            'data' => $user,
        ], 200);
    }

    public function destroy(Request $request)
    {

        $id = $request->input('id');

        if (!$id) {
            return response()->json([
                'status' => false,
                'message' => 'Missing required key: id',
                'data' => []
            ], 400);
        }
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found',
                'data' => []
            ], 404);
        }

        $authUser = auth()->user();
        if ($authUser->id === $user->id) {
            return response()->json([
                'status' => false,
                'message' => 'You cannot delete yourself',
                'data' => []
            ], 403);
        }
        if (!in_array($authUser->role_id, [1, 2]) || $authUser->society_id !== $user->society_id) {
            return response()->json([
                'status' => false,
                'message' => 'You are not authorized to delete this user',
                'data' => []
            ], 403);
        }
        // DB::table('visitors')->where('user_id', $user->id)->delete();
        // $user->delete();
        // $user->status = 'inactive';
        $user->update([
            'status' => 'inactive'
        ]);

        return response()->json([
            'status' => true,
            'message' => 'User deactivated successfully',
            'data' => []
        ], 200);
    }

    public function familyMemberCount($userId)
    {
        $count = \App\Models\FamilyMemberDetail::where('user_id', $userId)->count();

        return $count;
    }
}
