<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Society;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

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

    // public function index(Request $request)
    // {
    //     $id = $request->input('id');
    //     $society_id = $request->input('society_id', auth()->user()->society_id); // Default to null if society_id is not provided
    //     // dd(auth()->user()->society_id);
    //     if (!$id) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Missing required key: id',
    //             'data' => []
    //         ], 400);
    //     }

    //     // If society_id is provided, filter users by society_id
    //     if ($society_id) {
    //         // Validate society_id to ensure it exists in the societies table
    //         $society = Society::find($society_id);
    //         if (!$society) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Society not found',
    //                 'data' => []
    //             ], 404);
    //         }

    //         // Add filtering for society_id in the user query
    //         $usersQuery = User::where('society_id', $society_id);
    //     } else {
    //         // If no society_id is provided, fetch all users without filtering
    //         $usersQuery = User::query();
    //     }

    //     // Fetch all users for 'all' id or single user if id is specific
    //     if ($id === 'all') {
    //         $users = $usersQuery->get()->groupBy('block'); // Group users by block

    //         // Sort blocks by title in ascending order
    //         $users = $users->sortKeys(); // Sort blocks alphabetically by block title

    //         $data = [];

    //         foreach ($users as $blockTitle => $usersInBlock) {
    //             $blockData = [
    //                 'title' => $blockTitle,
    //                 'society_id' => $society_id,  // Add society_id to each block
    //                 'rows' => []
    //             ];

    //             foreach ($usersInBlock as $index => $user) {
    //                 $blockData['rows'][] = [
    //                     'no' => $index + 1,
    //                     'id' => $user->id,
    //                     'blockNumber' => $user->block_number,
    //                     'image' => $user->profile_photo ? asset('storage/' . $user->profile_photo) : 'default_image_url',
    //                     'ownerName' => $user->first_name . ' ' . $user->last_name,
    //                     'role' => $user->role,
    //                     'status' => $user->status,
    //                     'mobile' => $user->mobile,
    //                     'totalMembers' => $this->familyMemberCount($user->id), // Adjust the total members count as needed
    //                     'society_id' => $user->society_id ?? null, // Return society_id or null if not set
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
    //     $user = $usersQuery->find($id);
    //     if ($user) {
    //         return response()->json([
    //             'status' => true,
    //             'message' => 'User fetched successfully',
    //             'data' => [
    //                 'society_id' => $user->society_id ?? null, // Return society_id or null if not set
    //                 'user' => $user
    //             ]
    //         ]);
    //     }

    //     return response()->json([
    //         'status' => false,
    //         'message' => 'User not found',
    //         'data' => []
    //     ], 404);
    // }

    // public function index(Request $request)
    // {
    //     // dd(auth()->user()->id);
    //     $id = $request->input('id');
    //     $society_id = $request->input('society_id', auth()->user()->society_id); // Default to null if society_id is not provided

    //     if (!$id) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Missing required key: id',
    //             'data' => []
    //         ], 400);
    //     }

    //     // Start with base query filtering by "active" status and specific roles
    //     $usersQuery = User::where('status', 'active')->whereIn('role', ['owner', 'tenant']); // Filter by 'owner' and 'tenant' roles

    //     // If society_id is provided, filter users by society_id
    //     if ($society_id) {
    //         $society = Society::find($society_id);
    //         if (!$society) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Society not found',
    //                 'data' => []
    //             ], 404);
    //         }

    //         // Add filtering for society_id in the user query
    //         $usersQuery->where('society_id', $society_id);
    //     }

    //     // Fetch all users for 'all' id or single user if id is specific
    //     if ($id === 'all') {
    //         $users = $usersQuery->get()->groupBy('block'); // Group users by block

    //         $users = $users->sortKeys(); // Sort blocks alphabetically by block title

    //         $data = [];

    //         foreach ($users as $blockTitle => $usersInBlock) {
    //             $blockData = [
    //                 'title' => $blockTitle,
    //                 'society_id' => $society_id,  // Add society_id to each block
    //                 'rows' => []
    //             ];

    //             foreach ($usersInBlock as $index => $user) {
    //                 $blockData['rows'][] = [
    //                     'no' => $index + 1,
    //                     'id' => $user->id,
    //                     'blockNumber' => $user->block_number,
    //                     'image' => $user->profile_photo ? asset('storage/' . $user->profile_photo) : 'default_image_url',
    //                     'ownerName' => $user->first_name . ' ' . $user->last_name,
    //                     'role' => $user->role,
    //                     'status' => $user->status,
    //                     'mobile' => $user->mobile,
    //                     'totalMembers' => $this->familyMemberCount($user->id),
    //                     'society_id' => $user->society_id ?? null,
    //                     'email' => $user->email,
    //                     'email_verified_at' => $user->email_verified_at,
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
    //     $user = $usersQuery->find($id);
    //     if ($user) {
    //         return response()->json([
    //             'status' => true,
    //             'message' => 'User fetched successfully',
    //             'data' => [
    //                 'society_id' => $user->society_id ?? null,
    //                 'user' => $user
    //             ]
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
        $society_id = $request->input('society_id', auth()->user()->society_id); // Default to user's society_id if not provided

        if (!$id) {
            return response()->json([
                'status' => false,
                'message' => 'Missing required key: id',
                'data' => []
            ], 400);
        }

        $currentUser = auth()->user();

        // Only allow Owner (3) and Tenant (4)
        if (!in_array($currentUser->role_id, [1, 2, 3, 4])) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized access',
                'data' => []
            ], 403);
        }

        // Define query
        $usersQuery = User::query()
            ->whereIn('role_id', [3, 4]) // Only fetch Owner & Tenant
            ->where('status', 'active');

        // If society_id is provided, validate it
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

        // Fetch users
        if ($id === 'all') {
            $users = $usersQuery->get()->groupBy('block');

            $users = $users->sortKeys();

            $data = [];

            foreach ($users as $blockTitle => $usersInBlock) {
                $blockData = [
                    'title' => $blockTitle,
                    'society_id' => $society_id,
                    'rows' => []
                ];

                foreach ($usersInBlock as $index => $user) {
                    $blockData['rows'][] = [
                        'no' => $index + 1,
                        'id' => $user->id,
                        'blockNumber' => $user->block_number,
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

        // Fetch a specific user by ID
        $user = $usersQuery->find($id);
        if ($user) {
            return response()->json([
                'status' => true,
                'message' => 'User fetched successfully',
                'data' => [
                    'society_id' => $user->society_id ?? null,
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




    // public function inactiveUsers(Request $request)
    // {
    //     $id = $request->input('id');
    //     $society_id = $request->input('society_id', auth()->user()->society_id); // Default to null if society_id is not provided

    //     if (!$id) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Missing required key: id',
    //             'data' => []
    //         ], 400);
    //     }

    //     // Start with base query filtering by "inactive" status
    //     $usersQuery = User::where('status', 'inactive');

    //     // If society_id is provided, filter users by society_id
    //     if ($society_id) {
    //         $society = Society::find($society_id);
    //         if (!$society) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Society not found',
    //                 'data' => []
    //             ], 404);
    //         }

    //         // Add filtering for society_id in the user query
    //         $usersQuery->where('society_id', $society_id);
    //     }

    //     // Fetch all users for 'all' id or single user if id is specific
    //     if ($id === 'all') {
    //         $users = $usersQuery->get()->groupBy('block'); // Group users by block

    //         $users = $users->sortKeys(); // Sort blocks alphabetically by block title

    //         $data = [];

    //         foreach ($users as $blockTitle => $usersInBlock) {
    //             $blockData = [
    //                 'title' => $blockTitle,
    //                 'society_id' => $society_id,  // Add society_id to each block
    //                 'rows' => []
    //             ];

    //             foreach ($usersInBlock as $index => $user) {
    //                 $blockData['rows'][] = [
    //                     'no' => $index + 1,
    //                     'id' => $user->id,
    //                     'blockNumber' => $user->block_number,
    //                     'image' => $user->profile_photo ? asset('storage/' . $user->profile_photo) : 'default_image_url',
    //                     'ownerName' => $user->first_name . ' ' . $user->last_name,
    //                     'role' => $user->role,
    //                     'status' => $user->status,
    //                     'mobile' => $user->mobile,
    //                     'totalMembers' => $this->familyMemberCount($user->id),
    //                     'society_id' => $user->society_id ?? null,
    //                     'email' => $user->email,
    //                     'email_verified_at' => $user->email_verified_at,
    //                 ];
    //             }

    //             $data[] = $blockData;
    //         }

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Inactive users fetched successfully',
    //             'data' => $data
    //         ]);
    //     }

    //     // Fetch a specific user by ID
    //     $user = $usersQuery->find($id);
    //     if ($user) {
    //         return response()->json([
    //             'status' => true,
    //             'message' => 'User fetched successfully',
    //             'data' => [
    //                 'society_id' => $user->society_id ?? null,
    //                 'user' => $user
    //             ]
    //         ]);
    //     }

    //     return response()->json([
    //         'status' => false,
    //         'message' => 'User not found',
    //         'data' => []
    //     ], 404);
    // }




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
    //         return response()->json(['error' => 'Missing required keys', 'missing_keys' => $missingKeys], 200);
    //     }

    //     // Get the logged-in user
    //     $loggedInUser = auth()->user();

    //     // Check if the logged-in user is admin when creating non-admin users
    //     if ($request->role !== 'admin' && $loggedInUser->role !== 'admin') {
    //         return response()->json(['error' => 'Only admins can create non-admin users'], 200);
    //     }

    //     // Get society_id from the authenticated user's society_id
    //     $society_id = $loggedInUser->society_id;

    //     // Add society_id to validated data if it's available
    //     $validatedData = $request->validate([
    //         'block_number' => 'required|string|max:50|unique:users',
    //         'first_name' => 'required|string|max:50',
    //         'last_name' => 'required|string|max:50',
    //         'role' => 'required|in:owner,tenant',
    //         'mobile' => 'required|string|size:10|unique:users',
    //         'block' => 'required|string|max:50',
    //         'profile_photo' => 'nullable|image|max:2048',
    //         'status' => 'required|in:active,inactive',
    //         'email' => 'nullable|email|unique:users',
    //         'password' => 'nullable|string|min:8',
    //     ]);
    //     // dd();
    //     // Add the society_id to the validated data
    //     $validatedData['society_id'] = $society_id;

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
    // public function store(Request $request)
    // {
    //     return response()->json([
    //         'status' => false,
    //         'message' => 'This api is closed temporarily. New user will be creating using register method now.',
    //         'data' => []
    //     ], 200);
    // }


    public function inactiveUsers(Request $request)
    {
        $id = $request->input('id');
        $society_id = $request->input('society_id', auth()->user()->society_id); // Default to user's society_id if not provided

        if (!$id) {
            return response()->json([
                'status' => false,
                'message' => 'Missing required key: id',
                'data' => []
            ], 400);
        }

        $currentUser = auth()->user();

        // Only allow Owner (3) and Tenant (4)
        if (!in_array($currentUser->role_id, [1, 2, 3, 4])) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized access',
                'data' => []
            ], 403);
        }

        // Define query for inactive users
        $usersQuery = User::where('status', 'inactive')
            ->whereIn('role_id', [3, 4]); // Only Owners & Tenants

        // Validate and filter by society_id
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

        // Fetch all inactive users
        if ($id === 'all') {
            $users = $usersQuery->get()->groupBy('block')->sortKeys();

            $data = [];

            foreach ($users as $blockTitle => $usersInBlock) {
                $blockData = [
                    'title' => $blockTitle,
                    'society_id' => $society_id,
                    'rows' => []
                ];

                foreach ($usersInBlock as $index => $user) {
                    $blockData['rows'][] = [
                        'no' => $index + 1,
                        'id' => $user->id,
                        'blockNumber' => $user->block_number,
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

        // Fetch a specific inactive user by ID
        $user = $usersQuery->find($id);
        if ($user) {
            return response()->json([
                'status' => true,
                'message' => 'User fetched successfully',
                'data' => [
                    'society_id' => $user->society_id ?? null,
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

    //     // Check for missing keys
    //     $missingKeys = [];
    //     foreach ($requiredKeys as $key) {
    //         if (!$request->has($key)) {
    //             $missingKeys[] = $key;
    //         }
    //     }

    //     if (!empty($missingKeys)) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Missing required keys',
    //             'missing_keys' => $missingKeys
    //         ], 400);
    //     }

    //     // Get logged-in user
    //     $loggedInUser = auth()->user();

    //     // Check if the logged-in user is an admin
    //     if ($loggedInUser->role !== 'admin') {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Only admins can create users'
    //         ], 403);
    //     }

    //     // Ensure user is created within the same society
    //     $society_id = $loggedInUser->society_id;

    //     // Validate input
    //     $validatedData = $request->validate([
    //         'block_number' => 'required|string|max:50|unique:users',
    //         'first_name' => 'required|string|max:50',
    //         'last_name' => 'required|string|max:50',
    //         'role' => 'required|in:owner,tenant', // Only owner & tenant can be created by admin
    //         'mobile' => 'required|string|size:10|unique:users',
    //         'block' => 'required|string|max:50',
    //         'profile_photo' => 'nullable|image|max:2048',
    //         'status' => 'required|in:active,inactive',
    //         'email' => 'nullable|email|unique:users',
    //         'password' => 'nullable|string|min:8',
    //     ]);

    //     // Assign society_id from the logged-in admin
    //     $validatedData['society_id'] = $society_id;

    //     // Handle profile photo upload
    //     if ($request->hasFile('profile_photo')) {
    //         $profilePhotoPath = $request->file('profile_photo')->store('profile_photos', 'public');
    //         $validatedData['profile_photo'] = $profilePhotoPath;
    //     }

    //     // Encrypt password if provided
    //     if ($request->filled('password')) {
    //         $validatedData['password'] = bcrypt($request->password);
    //     }

    //     try {
    //         $user = User::create($validatedData);
    //         return response()->json([
    //             'status' => true,
    //             'message' => 'User created successfully',
    //             'data' => $user
    //         ], 201);
    //     } catch (\Exception $e) {
    //         Log::error('Error creating user: ' . $e->getMessage());
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Internal Server Error'
    //         ], 500);
    //     }
    // }





    // Handle updating a user
    // public function update(Request $request)
    // {
    //     $id = $request->input('id');
    //     if (!$id) {
    //         return response()->json(['error' => 'Missing required key: id'], 400);
    //     }

    //     $user = User::find($id);
    //     if (!$user) {
    //         return response()->json(['error' => 'User not found'], 404);
    //     }

    //     $validatedData = $request->validate([
    //         'block_number' => "sometimes|required|string|max:50|unique:users,block_number,$id",
    //         'first_name' => 'sometimes|required|string|max:50',
    //         'last_name' => 'sometimes|required|string|max:50',
    //         'role' => 'sometimes|required|in:owner,admin,coowner,committee',
    //         'mobile' => "sometimes|required|string|size:10|unique:users,mobile,$id",
    //         'block' => 'sometimes|required|string|max:50',
    //         'profile_photo' => 'nullable|string|max:256',
    //         'status' => 'sometimes|required|in:active,inactive',
    //     ]);

    //     $user->update($validatedData);

    //     return response()->json($user, 200);
    // }


    // public function store(Request $request)
    // {
    //     // dd($request);
    //     // Define required keys
    //     $requiredKeys = [
    //         'first_name',
    //         'last_name',
    //         'mobile',
    //         'email',
    //         'profile_photo',
    //         'block_number',
    //         'block',
    //         'status',
    //         'role_id', // role_id must be passed
    //     ];

    //     // Check for missing required keys
    //     $missingKeys = [];
    //     foreach ($requiredKeys as $key) {
    //         if (!$request->has($key)) {
    //             $missingKeys[] = $key;
    //         }
    //     }

    //     if (!empty($missingKeys)) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Missing required keys',
    //             'missing_keys' => $missingKeys
    //         ], 400);
    //     }

    //     // Get logged-in user
    //     $loggedInUser = auth()->user();

    //     // Only super-admin (1) or admin (2) can create users
    //     if (!in_array($loggedInUser->role_id, [1, 2])) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Only super-admin or admin can create users'
    //         ], 403);
    //     }

    //     // Ensure the user is created within the same society
    //     $society_id = $loggedInUser->society_id;

    //     // Validate input
    //     $validatedData = $request->validate([
    //         'first_name' => 'required|string|max:50',
    //         'last_name' => 'required|string|max:50',
    //         'mobile' => 'required|string|size:10',
    //         'profile_photo' => 'required|image',
    //         'email' => 'nullable|email',
    //         'block_number' => 'required|string|max:50',
    //         'block' => 'required|string|max:50',
    //         'status' => 'required|in:active,inactive',
    //         'role_id' => 'required|in:3,4', // Ensure role_id is either 3 (owner) or 4 (tenant)
    //     ]);

    //     // Assign society_id from the logged-in admin
    //     $validatedData['society_id'] = $society_id;

    //     // Debugging: Log role_id being passed
    //     Log::info('Role ID from request: ' . $request->role_id);

    //     // if ($request->hasFile('profile_photo')) {
    //     //     $profilePhotoPath = $request->file('profile_photo')->store('profile_photos', 'public');
    //     //     $validatedData['profile_photo'] = $profilePhotoPath;
    //     // }
    //     $guardImagePath = $this->storeFileInPublicFolder($request->file('profile_photo'), 'profile_photos');
    //     $validatedData['profile_photo'] = $guardImagePath;

    //     // Encrypt password if provided
    //     if ($request->filled('password')) {
    //         $validatedData['password'] = bcrypt($request->password);
    //     }

    //     // Ensure role_id is stored as an integer
    //     $validatedData['role_id'] = (int)$request->role_id;

    //     // Attempt user creation
    //     try {
    //         $user = User::create($validatedData);
    //         return response()->json([
    //             'status' => true,
    //             'message' => 'User created successfully',
    //             'data' => $user
    //         ], 201);
    //     } catch (\Exception $e) {
    //         Log::error('Error creating user: ' . $e->getMessage());
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Internal Server Error'
    //         ], 500);
    //     }
    // }

    public function store(Request $request)
    {
        // Get logged-in user
        $loggedInUser = auth()->user();

        // Only super-admin (1) or admin (2) can create users
        if (!in_array($loggedInUser->role_id, [1, 2])) {
            return response()->json([
                'status' => false,
                'message' => 'Only super-admin or admin can create users'
            ], 403);
        }

        // Validate input
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'mobile' => 'required|digits:10', // Only numbers, exactly 10 digits
            'profile_photo' => 'required|image', // Ensuring image format
            'email' => 'nullable|email',
            'block_number' => 'required|string|max:50',
            'status' => 'required|in:active,inactive',
            'role_id' => 'required|in:3,4', // Ensure role_id is either 3 (owner) or 4 (tenant)
        ]);

        // Auto-derive block from block_number
        $validatedData['block'] = strtoupper(substr($validatedData['block_number'], 0, 1));

        // Assign society_id from the logged-in admin
        $validatedData['society_id'] = $loggedInUser->society_id;

        // Store profile photo using custom method
        $validatedData['profile_photo'] = $this->storeFileInPublicFolder($request->file('profile_photo'), 'profile_photos');

        // Encrypt password if provided
        if ($request->filled('password')) {
            $validatedData['password'] = bcrypt($request->password);
        }

        // Ensure role_id is stored as an integer
        $validatedData['role_id'] = (int)$validatedData['role_id'];
        // dd($validatedData);

        // Attempt user creation
        try {
            $user = User::create($validatedData);
            return response()->json([
                'status' => true,
                'message' => 'User created successfully',
                'data' => $user
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error creating user: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            // dd($e);
            return response()->json([
                'status' => false,
                'message' => 'Internal Server Error'
            ], 500);
        }
    }


    protected function storeFileInPublicFolder($file, $folder)
    {
        // dd($file);
        // if ($file == null) {
        //     return response()->json([
        //         'status' => false,
        //         'message' => 'Profile photo is required. try to upload again.'
        //     ], 200);
        // }
        // Generate a unique file name
        $filename = time() . '_' . $file->getClientOriginalName();
        $filename = str_replace(' ', '_', $filename);
        // Move the file to the desired folder in public/storage
        $file->move(public_path("storage/{$folder}"), $filename);

        // Return the relative path to the file
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
        // dd($request->input('status') == 'inactive');
        if ($request->has('status')) {
            if ($request->input('status') == 'inactive') {
                $user->deleted_at = now();
            }
        }


        // Get the logged-in user
        $authUser = auth()->user();

        // Allow only the user to update their own fields, or admins to update any user in the same society
        if ($authUser->id !== $user->id && $authUser->role_id !== 1 && $authUser->role_id !== 2) {
            return response()->json(['status' => false, 'message' => 'You are not authorized to update this user'], 403);
        }

        // Admins can only update users within their society
        if ($authUser->role_id === 2 && $authUser->society_id !== $user->society_id) {
            return response()->json(['status' => false, 'message' => 'You can only update users in your own society'], 403);
        }

        // Validate input data
        $validatedData = $request->validate([
            'block_number' => 'sometimes|required|string|max:50', // No uniqueness check
            'first_name' => 'sometimes|required|string|max:50',
            'last_name' => 'sometimes|required|string|max:50',
            'role_id' => 'sometimes|required|exists:roles,id', // Ensure role_id exists in roles table
            'mobile' => 'sometimes|required|string|size:10', // No uniqueness check
            'block' => 'sometimes|required|string|max:50',
            'profile_photo' => 'nullable|image|max:2048', // Ensure it's an image
            'status' => 'sometimes|required|in:active,inactive',
            'email' => 'sometimes|nullable|email', // No uniqueness check
            'password' => 'nullable|string|min:6', // Make password nullable for updates
        ]);

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');
            $filename = str_replace(' ', '_', $file->getClientOriginalName());
            // dd($filename);
            $fileName = time() . '_' . $filename;
            $destinationPath = public_path('storage/profile_photos');
            $file->move($destinationPath, $fileName);
            $validatedData['profile_photo'] = 'profile_photos/' . $fileName;
        }

        // Hash password if provided
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



    // // Handle deleting a user
    // public function destroy(Request $request)
    // {
    //     $id = $request->input('id');
    //     if (!$id) {
    //         return response()->json(['error' => 'Missing required key: id'], 400);
    //     }

    //     $user = User::find($id);
    //     if (!$user) {
    //         return response()->json(['error' => 'User not found'], 404);
    //     }

    //     $user->familyMembers()->delete();
    //     $user->vehicles()->delete();
    //     $user->visitors()->delete();
    //     $user->delete();

    //     return response()->json(['message' => 'User deleted'], 204);
    // }

    // Handle deleting a user
    // public function destroy(Request $request)
    // {
    //     $id = $request->input('id');

    //     if (!$id) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Missing required key: id',
    //             'data' => []
    //         ], 400);
    //     }

    //     // Find the user to be deleted
    //     $user = User::find($id);
    //     if (!$user) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'User not found',
    //             'data' => []
    //         ], 404);
    //     }

    //     $authUser = auth()->user();

    //     // Prevent logged-in user from deleting themselves
    //     if ($authUser->id === $user->id) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'You cannot delete yourself',
    //             'data' => []
    //         ], 403); // Forbidden: Can't delete own account
    //     }

    //     // Check if the logged-in user is an admin or super-admin, and if the society_id matches
    //     if (!in_array($authUser->role_id, [1, 2]) || $authUser->society_id !== $user->society_id) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'You are not authorized to delete this user',
    //             'data' => []
    //         ], 403); // Forbidden status code
    //     }

    //     // Perform a soft delete for the user and associated records
    //     $user->delete(); // Soft delete the user

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'User soft-deleted successfully',
    //         'data' => []
    //     ], 200);
    // }

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

        // Find the user to be deleted
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found',
                'data' => []
            ], 404);
        }

        $authUser = auth()->user();

        // Prevent logged-in user from deleting themselves
        if ($authUser->id === $user->id) {
            return response()->json([
                'status' => false,
                'message' => 'You cannot delete yourself',
                'data' => []
            ], 403);
        }

        // Check if the logged-in user is an admin or super-admin, and if the society_id matches
        if (!in_array($authUser->role_id, [1, 2]) || $authUser->society_id !== $user->society_id) {
            return response()->json([
                'status' => false,
                'message' => 'You are not authorized to delete this user',
                'data' => []
            ], 403);
        }

        // Delete related visitor records first
        DB::table('visitors')->where('user_id', $user->id)->delete();

        // Perform a soft delete for the user
        $user->delete();

        return response()->json([
            'status' => true,
            'message' => 'User soft-deleted successfully',
            'data' => []
        ], 200);
    }




    public function familyMemberCount($userId)
    {
        $count = \App\Models\FamilyMemberDetail::where('user_id', $userId)->count(); // Count family members for specific user_id

        return $count;
    }
}
