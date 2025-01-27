<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Society;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UsersController extends Controller
{
    // Handle fetching users
    // public function index(Request $request)
    // {
    //     $id = $request->input('id');

    //     if (!$id) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Missing required key: id',
    //             'data' => []
    //         ], 400);
    //     }

    //     // Fetch all users for 'all' id or single user if id is specific
    //     if ($id === 'all') {
    //         $blocks = User::all()->groupBy('block'); // Group users by block

    //         // Sort blocks by title in ascending order
    //         $blocks = $blocks->sortKeys(); // Sort blocks alphabetically by block title

    //         $data = [];

    //         foreach ($blocks as $blockTitle => $users) {
    //             $blockData = [
    //                 'title' => $blockTitle,
    //                 'rows' => []
    //             ];

    //             foreach ($users as $index => $user) {
    //                 $blockData['rows'][] = [
    //                     'no' => $index + 1,
    //                     'id' => $user->id,
    //                     'blockNumber' => $user->block_number,
    //                     'image' => $user->profile_photo ? asset('storage/' . $user->profile_photo) : 'default_image_url',
    //                     'ownerName' => $user->first_name . ' ' . $user->last_name,
    //                     'role' => $user->role,
    //                     'mobile' => $user->mobile,
    //                     'totalMembers' => $this->familyMemberCount($user->id), // Adjust the total members count as needed
    //                 ];
    //             }

    //             $data[] = $blockData;
    //         }

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Users fetched successfully',
    //             'data' => $data
    //         ]);
    //     }

    //     // Fetch a specific user by ID
    //     $user = User::find($id);
    //     if ($user) {
    //         return response()->json([
    //             'status' => true,
    //             'message' => 'User fetched successfully',
    //             'data' => $user
    //         ]);
    //     }

    //     return response()->json([
    //         'status' => false,
    //         'message' => 'User not found',
    //         'data' => []
    //     ], 404);
    // }

    public function index(Request $request)
    {
        $id = $request->input('id');
        $society_id = $request->input('society_id', auth()->user()->society_id); // Default to null if society_id is not provided
        // dd(auth()->user()->society_id);
        if (!$id) {
            return response()->json([
                'status' => false,
                'message' => 'Missing required key: id',
                'data' => []
            ], 400);
        }

        // If society_id is provided, filter users by society_id
        if ($society_id) {
            // Validate society_id to ensure it exists in the societies table
            $society = Society::find($society_id);
            if (!$society) {
                return response()->json([
                    'status' => false,
                    'message' => 'Society not found',
                    'data' => []
                ], 404);
            }

            // Add filtering for society_id in the user query
            $usersQuery = User::where('society_id', $society_id);
        } else {
            // If no society_id is provided, fetch all users without filtering
            $usersQuery = User::query();
        }

        // Fetch all users for 'all' id or single user if id is specific
        if ($id === 'all') {
            $users = $usersQuery->get()->groupBy('block'); // Group users by block

            // Sort blocks by title in ascending order
            $users = $users->sortKeys(); // Sort blocks alphabetically by block title

            $data = [];

            foreach ($users as $blockTitle => $usersInBlock) {
                $blockData = [
                    'title' => $blockTitle,
                    'society_id' => $society_id,  // Add society_id to each block
                    'rows' => []
                ];

                foreach ($usersInBlock as $index => $user) {
                    $blockData['rows'][] = [
                        'no' => $index + 1,
                        'id' => $user->id,
                        'blockNumber' => $user->block_number,
                        'image' => $user->profile_photo ? asset('storage/' . $user->profile_photo) : 'default_image_url',
                        'ownerName' => $user->first_name . ' ' . $user->last_name,
                        'role' => $user->role,
                        'mobile' => $user->mobile,
                        'totalMembers' => $this->familyMemberCount($user->id), // Adjust the total members count as needed
                        'society_id' => $user->society_id ?? null, // Return society_id or null if not set
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

        // Fetch a specific user by ID
        $user = $usersQuery->find($id);
        if ($user) {
            return response()->json([
                'status' => true,
                'message' => 'User fetched successfully',
                'data' => [
                    'society_id' => $user->society_id ?? null, // Return society_id or null if not set
                    'user' => $user
                ]
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'User not found',
            'data' => []
        ], 404);
    }



    //Handle user creation
    // public function store(Request $request)
    // {
    //     $requiredKeys = [
    //         'block_number',
    //         'first_name',
    //         'last_name',
    //         'role',
    //         'mobile',
    //         'block',
    //         'status'
    //     ];

    //     $missingKeys = [];
    //     foreach ($requiredKeys as $key) {
    //         if (!$request->has($key)) {
    //             $missingKeys[] = $key;
    //         }
    //     }

    //     if (!empty($missingKeys)) {
    //         return response()->json(['error' => 'Missing required keys', 'missing_keys' => $missingKeys], 400);
    //     }

    //     $validatedData = $request->validate([
    //         'block_number' => 'required|string|max:50|unique:users',
    //         'first_name' => 'required|string|max:50',
    //         'last_name' => 'required|string|max:50',
    //         'role' => 'required|in:owner,admin,coowner,committee',
    //         'mobile' => 'required|string|size:10|unique:users',
    //         'block' => 'required|string|max:50',
    //         'profile_photo' => 'nullable|image|max:2048',
    //         'status' => 'required|in:active,inactive',
    //         'email' => 'nullable|email|unique:users',
    //         'password' => 'nullable|string|min:8',
    //     ]);

    //     if ($request->hasFile('profile_photo')) {
    //         $profilePhotoPath = $request->file('profile_photo')->store('profile_photos', 'public');
    //         $validatedData['profile_photo'] = $profilePhotoPath;
    //     }

    //     if ($request->filled('password')) {
    //         $validatedData['password'] = bcrypt($request->password);
    //     }

    //     try {
    //         $user = User::create($validatedData);
    //         return response()->json(['message' => 'User created successfully', 'user' => $user], 201);
    //     } catch (\Exception $e) {
    //         Log::error('Error creating user: ' . $e->getMessage());
    //         return response()->json(['message' => 'Internal Server Error'], 500);
    //     }
    // }

    public function store(Request $request)
    {
        $requiredKeys = [
            'block_number',
            'first_name',
            'last_name',
            'role',
            'mobile',
            'block',
            'status'
        ];

        $missingKeys = [];
        foreach ($requiredKeys as $key) {
            if (!$request->has($key)) {
                $missingKeys[] = $key;
            }
        }

        if (!empty($missingKeys)) {
            return response()->json(['error' => 'Missing required keys', 'missing_keys' => $missingKeys], 200);
        }

        // Get the logged-in user
        $loggedInUser = auth()->user();

        // Check if the logged-in user is admin when creating non-admin users
        if ($request->role !== 'admin' && $loggedInUser->role !== 'admin') {
            return response()->json(['error' => 'Only admins can create non-admin users'], 200);
        }

        // Get society_id from the authenticated user's society_id
        $society_id = $loggedInUser->society_id;

        // Add society_id to validated data if it's available
        $validatedData = $request->validate([
            'block_number' => 'required|string|max:50|unique:users',
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'role' => 'required|in:owner,admin,coowner,committee',
            'mobile' => 'required|string|size:10|unique:users',
            'block' => 'required|string|max:50',
            'profile_photo' => 'nullable|image|max:2048',
            'status' => 'required|in:active,inactive',
            'email' => 'nullable|email|unique:users',
            'password' => 'nullable|string|min:8',
        ]);
        // dd();
        // Add the society_id to the validated data
        $validatedData['society_id'] = $society_id;

        if ($request->hasFile('profile_photo')) {
            $profilePhotoPath = $request->file('profile_photo')->store('profile_photos', 'public');
            $validatedData['profile_photo'] = $profilePhotoPath;
        }

        if ($request->filled('password')) {
            $validatedData['password'] = bcrypt($request->password);
        }

        try {
            $user = User::create($validatedData);
            return response()->json(['message' => 'User created successfully', 'user' => $user], 201);
        } catch (\Exception $e) {
            Log::error('Error creating user: ' . $e->getMessage());
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }




    // Handle updating a user
    public function update(Request $request)
    {
        $id = $request->input('id');
        if (!$id) {
            return response()->json(['error' => 'Missing required key: id'], 400);
        }

        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $validatedData = $request->validate([
            'block_number' => "sometimes|required|string|max:50|unique:users,block_number,$id",
            'first_name' => 'sometimes|required|string|max:50',
            'last_name' => 'sometimes|required|string|max:50',
            'role' => 'sometimes|required|in:owner,admin,coowner,committee',
            'mobile' => "sometimes|required|string|size:10|unique:users,mobile,$id",
            'block' => 'sometimes|required|string|max:50',
            'profile_photo' => 'nullable|string|max:256',
            'status' => 'sometimes|required|in:active,inactive',
        ]);

        $user->update($validatedData);

        return response()->json($user, 200);
    }

    // Handle deleting a user
    public function destroy(Request $request)
    {
        $id = $request->input('id');
        if (!$id) {
            return response()->json(['error' => 'Missing required key: id'], 400);
        }

        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $user->familyMembers()->delete();
        $user->vehicles()->delete();
        $user->visitors()->delete();
        $user->delete();

        return response()->json(['message' => 'User deleted'], 204);
    }

    public function familyMemberCount($userId)
    {
        $count = \App\Models\FamilyMemberDetail::where('user_id', $userId)->count(); // Count family members for specific user_id

        return $count;
    }
}
