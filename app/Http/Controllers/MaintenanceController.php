<?php

namespace App\Http\Controllers;

use App\Models\Maintenance;
use App\Models\User;
use Illuminate\Http\Request;

use function PHPSTORM_META\map;

class MaintenanceController extends Controller
{
    // Fetch all maintenance records
    // public function index(Request $request)
    // {
    //     // Fetch the last pending maintenance record per user_id
    //     $pendingRecords = Maintenance::select('id', 'block_number', 'user_id', 'owner_name', 'amount', 'date', 'description', 'maintenance_status', 'photo')
    //         ->where('maintenance_status', 'Pending')
    //         ->orderBy('id', 'desc')
    //         ->get()
    //         ->keyBy('user_id');

    //     // Fetch the last completed maintenance record per user_id where no pending records exist
    //     $completedRecords = Maintenance::select('id', 'block_number', 'user_id', 'owner_name', 'amount', 'date', 'description', 'maintenance_status', 'photo')
    //         ->whereNotIn('user_id', $pendingRecords->keys())
    //         ->orderBy('id', 'desc')
    //         ->get()
    //         ->keyBy('user_id');

    //     // Merge both pending and completed records ensuring only one record per user_id
    //     $allRecords = $pendingRecords->union($completedRecords);

    //     // Group records by the first letter of block_number
    //     $groupedRecords = $allRecords->groupBy(function ($record) {
    //         return strtoupper(substr($record->block_number, 0, 1));
    //     });

    //     // Format the response to match the specified structure
    //     $response = $groupedRecords->map(function ($records, $blockLetter) {
    //         return [
    //             'title' => "Block-" . $blockLetter,  // Ensure block title format "Block-A", "Block-B", etc.
    //             'rows' => $records->values()->map(function ($record, $index) {
    //                 $date = \Carbon\Carbon::parse($record->date);  // Convert string to Carbon instance
    //                 return [
    //                     'no' => $index + 1,
    //                     'id' => $record->id,
    //                     'user_id' => $record->user_id,
    //                     'blockNumber' => $record->block_number,
    //                     'image' => config('app.url') . '/public/storage/' . $record->photo,  // Assuming a default image, replace as needed
    //                     'ownerName' => $record->owner_name,
    //                     'maintenance_status' => $record->maintenance_status,
    //                     // 'amount' => (string)$record->amount,  // Ensure amount is in string format
    //                     // 'date' => $date->format('d/m/Y'),  // Format date
    //                     // 'description' => $record->description,
    //                     // 'status' => ucfirst(strtolower($record->maintenance_status)),  // Ensure proper capitalization
    //                 ];
    //             })->toArray(),
    //         ];
    //     });

    //     // Sort the response by block title alphabetically
    //     $sortedResponse = $response->sortBy('title')->values();

    //     // Return the response with grouped, formatted, and sorted data
    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Maintenance records fetched successfully',
    //         'data' => $sortedResponse->toArray(),
    //     ], 200);
    // }

    // Fetch all maintenance records
    // public function index(Request $request)
    // {
    //     // Get the logged-in user
    //     $loggedInUser = auth()->user();
    //     $loggedInSocietyId = $loggedInUser->society_id;

    //     // Check if the user is an admin
    //     $isAdmin = $loggedInUser->role_id === 2; // Role ID for 'admin' is 2

    //     // If the user is not an admin, restrict to their maintenance records
    //     if (!$isAdmin) {
    //         $userMaintenance = Maintenance::with('user:id,society_id') // Eager load user's society_id
    //             ->where('user_id', $loggedInUser->id)
    //             ->orderBy('id', 'desc')
    //             ->get();

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Maintenance records fetched successfully',
    //             'data' => $this->formatMaintenanceRecords($userMaintenance),
    //         ], 200);
    //     }

    //     // Fetch pending maintenance records for all users in the same society
    //     $pendingRecords = Maintenance::with('user:id,society_id') // Eager load user's society_id
    //         ->select('id', 'block_number', 'user_id', 'owner_name', 'amount', 'date', 'description', 'maintenance_status', 'photo')
    //         ->where('maintenance_status', 'Pending')
    //         ->whereHas('user', function ($query) use ($loggedInSocietyId) {
    //             $query->where('society_id', $loggedInSocietyId);
    //         })
    //         ->orderBy('id', 'desc')
    //         ->get()
    //         ->keyBy('user_id');

    //     // Fetch completed maintenance records where no pending records exist
    //     $completedRecords = Maintenance::with('user:id,society_id') // Eager load user's society_id
    //         ->select('id', 'block_number', 'user_id', 'owner_name', 'amount', 'date', 'description', 'maintenance_status', 'photo')
    //         ->whereNotIn('user_id', $pendingRecords->keys())
    //         ->whereHas('user', function ($query) use ($loggedInSocietyId) {
    //             $query->where('society_id', $loggedInSocietyId);
    //         })
    //         ->orderBy('id', 'desc')
    //         ->get()
    //         ->keyBy('user_id');

    //     // Merge pending and completed records
    //     $allRecords = $pendingRecords->union($completedRecords);

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Maintenance records fetched successfully',
    //         'data' => $this->formatMaintenanceRecords($allRecords),
    //     ], 200);
    // }

    // public function index(Request $request)
    // {
    //     // Get the logged-in user
    //     $loggedInUser = auth()->user();
    //     $loggedInSocietyId = $loggedInUser->society_id;

    //     // Check if the user is an admin
    //     $isAdmin = $loggedInUser->role_id === 2; // Assuming 'admin' role ID is 2

    //     // If the user is not an admin, only fetch their maintenance records
    //     if (!$isAdmin) {
    //         $userMaintenance = Maintenance::with('user:id,first_name,last_name,society_id,block_number,mobile')
    //             ->where('user_id', $loggedInUser->id)
    //             ->orderBy('id', 'desc')
    //             ->get();

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Maintenance records fetched successfully',
    //             'data' => $this->formatMaintenanceRecords($userMaintenance),
    //         ], 200);
    //     }

    //     // Fetch all active users from the same society
    //     $activeUsers = User::where('society_id', $loggedInSocietyId)
    //         ->where('status', 'active')
    //         ->select('id', 'first_name', 'last_name', 'block_number', 'mobile', 'profile_photo')
    //         ->get();

    //     // Fetch all maintenance records for users in the society
    //     $maintenanceRecords = Maintenance::with('user:id,first_name,last_name,society_id,block_number,mobile,profile_photo')
    //         ->whereHas('user', function ($query) use ($loggedInSocietyId) {
    //             $query->where('society_id', $loggedInSocietyId);
    //         })
    //         ->orderBy('id', 'desc')
    //         ->get()
    //         ->groupBy('block_number'); // Group records by block_number

    //     // Group users and maintenance records by block number
    //     $groupedData = $activeUsers->groupBy('block_number')->map(function ($users, $block) use ($maintenanceRecords) {
    //         $blockMaintenance = $maintenanceRecords->get($block, collect());

    //         $rows = $users->map(function ($user) use ($blockMaintenance) {
    //             // Find corresponding maintenance records for the user
    //             $userMaintenance = $blockMaintenance->where('user_id', $user->id)->first();

    //             return [
    //                 'no' => $user->id,
    //                 'id' => $user->id,
    //                 'user_id' => $user->id,
    //                 'blockNumber' => $user->block_number,
    //                 'image' => $user->profile_photo ? url('storage/' . $user->profile_photo) : null,
    //                 'ownerName' => $user->first_name . ' ' . $user->last_name,
    //                 'maintenance_status' => $userMaintenance ? $userMaintenance->maintenance_status : 'No Maintenance',
    //                 'society_id' => $user->society_id,
    //             ];
    //         });

    //         return [
    //             'title' => $block,
    //             'rows' => $rows,
    //         ];
    //     });

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Maintenance records fetched successfully',
    //         'data' => $groupedData->values(), // Ensure the grouping is reset and values are returned as an array
    //     ], 200);
    // }

    // public function index(Request $request)
    // {
    //     // Get the logged-in user
    //     $loggedInUser = auth()->user();
    //     $loggedInSocietyId = $loggedInUser->society_id;

    //     // Check if the user is an admin
    //     $isAdmin = $loggedInUser->role_id === 2; // Assuming 'admin' role ID is 2

    //     // If the user is not an admin, only fetch their maintenance records
    //     if (!$isAdmin) {
    //         $userMaintenance = Maintenance::with('user:id,first_name,last_name,society_id,block_number,mobile')
    //             ->where('user_id', $loggedInUser->id)
    //             ->orderBy('id', 'desc')
    //             ->get();

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Maintenance records fetched successfully',
    //             'data' => $this->formatMaintenanceRecords($userMaintenance),
    //         ], 200);
    //     }

    //     // Fetch all active users from the same society
    //     $activeUsers = User::where('society_id', $loggedInSocietyId)
    //         ->whereIn('role_id', [3, 4]) // Only owners and tenants
    //         ->where('status', 'active')
    //         ->select('id', 'first_name', 'last_name', 'block_number', 'mobile', 'profile_photo')
    //         ->get();

    //     // Fetch all maintenance records for users in the society
    //     $maintenanceRecords = Maintenance::with('user:id,first_name,last_name,society_id,block_number,mobile,profile_photo')
    //         ->whereHas('user', function ($query) use ($loggedInSocietyId) {
    //             $query->where('society_id', $loggedInSocietyId);
    //         })
    //         ->orderBy('id', 'desc')
    //         ->get()
    //         ->groupBy('block_number'); // Group records by block_number

    //     // Group users and maintenance records by block number
    //     $groupedData = $activeUsers->groupBy('block_number')->map(function ($users, $block) use ($maintenanceRecords) {
    //         $blockMaintenance = $maintenanceRecords->get($block, collect());

    //         $rows = $users->map(function ($user) use ($blockMaintenance) {
    //             // Find corresponding maintenance records for the user
    //             $userMaintenance = $blockMaintenance->where('user_id', $user->id);

    //             // Map the maintenance records to the desired structure
    //             $maintenance = $userMaintenance->map(function ($maintenanceRecord) {
    //                 return [
    //                     'no' => $maintenanceRecord->id,
    //                     'id' => $maintenanceRecord->id,
    //                     'amount' => $maintenanceRecord->amount,
    //                     'date' => $maintenanceRecord->date,
    //                     'maintenance_status' => $maintenanceRecord->maintenance_status,
    //                 ];
    //             });

    //             return [
    //                 // 'no' => $user->id,
    //                 'user_id' => $user->id,
    //                 'blockNumber' => $user->block_number,
    //                 'image' => $user->profile_photo ? url('storage/' . $user->profile_photo) : null,
    //                 'ownerName' => $user->first_name . ' ' . $user->last_name,
    //                 'maintenance_status' => $userMaintenance->isEmpty() ? 'No Maintenance' : 'Has Maintenance',
    //                 'society_id' => $user->society_id,
    //                 'maintenance' => $maintenance, // Add the maintenance details here
    //             ];
    //         });

    //         return [
    //             'title' => substr($block, 0, 1),
    //             'rows' => $rows,
    //         ];
    //     });

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Maintenance records fetched successfully',
    //         'data' => $groupedData->values(), // Ensure the grouping is reset and values are returned as an array
    //     ], 200); // }







    /* */


    public function index(Request $request)
    {
        // Get the logged-in user
        $loggedInUser = auth()->user();
        $loggedInSocietyId = $loggedInUser->society_id;

        // Check if the user is an admin
        $isAdmin = $loggedInUser->role_id === 2; // Assuming 'admin' role ID is 2

        // If the user is not an admin, only fetch their maintenance records
        if (!$isAdmin) {
            $userMaintenance = Maintenance::with('user:id,first_name,last_name,society_id,block_number,mobile')
                ->where('user_id', $loggedInUser->id)
                ->orderBy('id', 'desc')
                ->get();

            // Check if the user has no maintenance records
            if ($userMaintenance->isEmpty()) {
                return response()->json([
                    'status' => true,
                    'message' => 'No maintenance records found.',
                    'data' => [
                        'maintenance_status' => 'No Maintenance'
                    ],
                ], 200);
            }

            // Determine if all maintenance records are approved or if there are any pending
            $allApproved = $userMaintenance->every(function ($maintenance) {
                return $maintenance->maintenance_status === 'Approved';
            });

            $maintenanceStatus = $allApproved ? 'All Maintenance Approved' : 'Some Maintenance Pending';

            return response()->json([
                'status' => true,
                'message' => 'Maintenance records fetched successfully',
                'data' => [
                    'maintenance_status' => $maintenanceStatus,
                    'maintenance_records' => $userMaintenance->map(function ($maintenanceRecord) {
                        return [
                            'no' => $maintenanceRecord->id,
                            'id' => $maintenanceRecord->id,
                            'amount' => $maintenanceRecord->amount,
                            'date' => $maintenanceRecord->date,
                            'maintenance_status' => $maintenanceRecord->maintenance_status,
                        ];
                    }),
                ],
            ], 200);
        }

        // Fetch all active users from the same society
        $activeUsers = User::where('society_id', $loggedInSocietyId)
            ->whereIn('role_id', [3, 4]) // Only owners and tenants
            ->where('status', 'active')
            ->select('id', 'first_name', 'last_name', 'block_number', 'mobile', 'profile_photo')
            ->get();

        // Fetch all maintenance records for users in the society
        $maintenanceRecords = Maintenance::with('user:id,first_name,last_name,society_id,block_number,mobile,profile_photo')
            ->whereHas('user', function ($query) use ($loggedInSocietyId) {
                $query->where('society_id', $loggedInSocietyId);
            })
            ->orderBy('id', 'desc')
            ->get();

        // Group users by block_number
        $groupedData = $activeUsers->groupBy('block_number')->map(function ($users, $block) use ($maintenanceRecords) {
            // Filter maintenance records for the current block
            $blockMaintenance = $maintenanceRecords->where('block_number', $block);

            $rows = $users->map(function ($user) use ($blockMaintenance) {
                // Find corresponding maintenance records for the user
                $userMaintenance = $blockMaintenance->where('user_id', $user->id);

                // If no maintenance record exists for the user
                if ($userMaintenance->isEmpty()) {
                    return [
                        'user_id' => $user->id,
                        'blockNumber' => $user->block_number,
                        'image' => $user->profile_photo ? url('storage/' . $user->profile_photo) : null,
                        'ownerName' => $user->first_name . ' ' . $user->last_name,
                        'maintenance_status' => 'No Maintenance',
                        'society_id' => $user->society_id,
                        'maintenance' => [],
                    ];
                }

                // Check if all maintenance records for the user are approved or if there are any pending
                $allApproved = $userMaintenance->every(function ($maintenance) {
                    return $maintenance->maintenance_status === 'Approved';
                });

                $maintenanceStatus = $allApproved ? 'All Maintenance Approved' : 'Some Maintenance Pending';

                // Map the maintenance records to the desired structure
                $maintenance = $userMaintenance->map(function ($maintenanceRecord) {
                    return [
                        'no' => $maintenanceRecord->id,
                        'id' => $maintenanceRecord->id,
                        'amount' => $maintenanceRecord->amount,
                        'date' => $maintenanceRecord->date,
                        'maintenance_status' => $maintenanceRecord->maintenance_status,
                    ];
                });

                return [
                    'user_id' => $user->id,
                    'blockNumber' => $user->block_number,
                    'image' => $user->profile_photo ? url('storage/' . $user->profile_photo) : null,
                    'ownerName' => $user->first_name . ' ' . $user->last_name,
                    'maintenance_status' => $maintenanceStatus,
                    'society_id' => $user->society_id,
                    'maintenance' => $maintenance, // Add the maintenance details here
                ];
            });

            return [
                'title' => substr($block, 0, 1),  // Use the first character of the block number
                'rows' => $rows->values(), // Ensure we get an indexed array
            ];
        });

        // Merge blocks that have the same title (e.g., 'A' -> ['A-102', 'A-104']) under a single 'title'
        $finalGroupedData = $groupedData->values()->groupBy('title')->map(function ($items) {
            return [
                'title' => $items->first()['title'],
                'rows' => $items->flatMap(function ($item) {
                    return $item['rows'];
                })->values(), // Flatten rows and re-index them
            ];
        });
        // dd($groupedData->values());

        // Sort blocks by title in ascending order while keeping groups merged
        $finalGroupedData = $finalGroupedData->sortBy(function ($item) {
            return $item['title']; // Sort by block number title
        })->values(); // Keep the sorted array as a proper collection


        return response()->json([
            'status' => true,
            'message' => 'Maintenance records fetched successfully',
            'data' => $finalGroupedData->values(), // Ensure the grouping is reset and values are returned as an array
        ], 200);
    }


    // public function index(Request $request)
    // {
    //     // Get the logged-in user
    //     $loggedInUser = auth()->user();
    //     $loggedInSocietyId = $loggedInUser->society_id;

    //     // Check if the user is an admin
    //     $isAdmin = $loggedInUser->role_id === 2; // Assuming 'admin' role ID is 2

    //     // If the user is not an admin, only fetch their maintenance records
    //     if (!$isAdmin) {
    //         $userMaintenance = Maintenance::with('user:id,first_name,last_name,society_id')
    //             ->where('user_id', $loggedInUser->id)
    //             ->orderBy('id', 'desc')
    //             ->get();

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Maintenance records fetched successfully',
    //             'data' => $this->formatMaintenanceRecords($userMaintenance),
    //         ], 200);
    //     }

    //     // Fetch all active users from the same society
    //     $activeUsers = User::where('society_id', $loggedInSocietyId)
    //         ->where('status', 'active')
    //         ->select('id', 'first_name', 'last_name', 'block_number', 'mobile')
    //         ->get();

    //     // Fetch all maintenance records for users in the society
    //     $maintenanceRecords = Maintenance::with('user:id,first_name,last_name,society_id')
    //         ->whereHas('user', function ($query) use ($loggedInSocietyId) {
    //             $query->where('society_id', $loggedInSocietyId);
    //         })
    //         ->orderBy('id', 'desc')
    //         ->get()
    //         ->groupBy('user_id'); // Group records by user_id for easy merging

    //     // Merge users and maintenance records
    //     $allUsersWithMaintenance = $activeUsers->map(function ($user) use ($maintenanceRecords) {
    //         return [
    //             'user_id' => $user->id,
    //             'first_name' => $user->first_name,
    //             'last_name' => $user->last_name,
    //             'block_number' => $user->block_number,
    //             'mobile' => $user->mobile,
    //             'maintenance' => $maintenanceRecords->get($user->id, collect()), // Return maintenance if exists, else empty
    //         ];
    //     });

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Maintenance records fetched successfully',
    //         'data' => $allUsersWithMaintenance,
    //     ], 200);
    // }



    /**
     * Helper method to format maintenance records
     */
    private function formatMaintenanceRecords($records)
    {
        // Group records by the first letter of block_number
        $groupedRecords = $records->groupBy(function ($record) {
            return strtoupper(substr($record->block_number, 0, 1));
        });

        // Format and structure grouped records
        return $groupedRecords->map(function ($records, $blockLetter) {
            return [
                'title' => "Block-" . $blockLetter,
                'rows' => $records->values()->map(function ($record, $index) {
                    $date = \Carbon\Carbon::parse($record->date); // Convert to Carbon instance
                    return [
                        'no' => $index + 1,
                        'id' => $record->id,
                        'user_id' => $record->user_id,
                        'blockNumber' => $record->block_number,
                        'image' => config('app.url') . '/public/storage/' . $record->photo,  // Updated URL path
                        'ownerName' => $record->owner_name,
                        'maintenance_status' => $record->maintenance_status,
                        'society_id' => $record->user->society_id, // Add user's society_id
                    ];
                })->toArray(),
            ];
        })->sortBy('title')->values()->toArray();
    }




    public function show(Request $request)
    {
        // Get the 'id' and 'user_id' parameters from the request body (JSON body)
        $id = $request->input('id');
        $userId = $request->input('user_id');

        // Check if either 'id' or 'user_id' is provided in the body
        if (!$id && !$userId) {
            return response()->json([
                'status' => false,
                'message' => 'Please provide either an ID or user_id to fetch records.',
                'data' => []
            ], 200);
        }

        // Initialize the maintenance query
        $maintenanceQuery = Maintenance::with('user:id,society_id'); // Eager load user relationship with society_id

        // If 'user_id' is provided, fetch all records for that user
        if ($userId) {
            $maintenanceQuery->where('user_id', $userId);
        }

        // If 'id' is provided, fetch a specific record by ID
        if ($id) {
            $maintenanceQuery->where('id', $id);
        }

        // Fetch the maintenance records and order them by 'date' descending
        $maintenanceRecords = $maintenanceQuery->orderBy('date', 'desc')->get();

        // Check if records were found
        if ($maintenanceRecords->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'No maintenance records found for the specified criteria.',
                'data' => []
            ], 200);
        }

        // Group records by block_number
        $groupedRecords = $maintenanceRecords->groupBy('block_number');

        // Format the response to return just the rows directly
        $response = $groupedRecords->map(function ($records, $blockNumber) {
            return $records->values()->map(function ($record, $index) {
                $date = \Carbon\Carbon::parse($record->date);  // Convert string to Carbon instance
                return [
                    'no' => $index + 1,
                    'id' => $record->id,
                    'user_id' => $record->user_id,
                    'blockNumber' => $record->block_number,
                    'image' => config('app.url') . '/public/storage/' . $record->photo,  // Updated URL path
                    'ownerName' => $record->owner_name,
                    'amount' => (string)$record->amount,
                    'maintenance_status' => $record->maintenance_status,
                    'date' => \Carbon\Carbon::parse($date)->format('d-m-Y'),
                    'description' => $record->description,
                    'status' => ucfirst(strtolower($record->maintenance_status)),
                    'society_id' => $record->user->society_id, // Add user's society_id here
                ];
            });
        });

        // Return the response with only rows (no title)
        return response()->json([
            'status' => true,
            'message' => 'Maintenance records fetched successfully',
            'data' => $response->flatten(1)->toArray()  // Flatten to remove title and just return rows
        ], 200);
    }



    public function store(Request $request)
    {
        // Initialize an array to track missing required arguments
        $missingArguments = [];

        // Check for each required field and add to missingArguments if not present
        $requiredFields = ['user_id', 'amount', 'date', 'description'];
        foreach ($requiredFields as $field) {
            if (!$request->has($field)) {
                $missingArguments[] = $field;
            }
        }

        // If any required arguments are missing, return a 200 response with the missing fields
        if (!empty($missingArguments)) {
            return response()->json([
                'status' => false,
                'message' => 'Missing required arguments',
                'missing_arguments' => $missingArguments
            ], 200);
        }

        // Validate the data
        $validated = $request->validate([
            'block_number' => 'nullable|string|max:50', // block_number is optional, will be fetched from user
            'maintenance_status' => 'nullable|in:PENDING,COMPLETED', // optional field
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|integer',
            'date' => 'required|date',
            'description' => 'required|string',
            'status' => 'nullable|in:active,deactive',
            'photo' => 'nullable|string|max:2048', // photo is optional
        ]);

        // Fetch the user to set the block number and owner name
        $user = User::find($validated['user_id']);
        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User not found'], 200);
        }

        // Set default maintenance_status to PENDING if not provided
        $maintenanceStatus = $validated['maintenance_status'] ?? 'PENDING';

        // Create a new maintenance record
        $maintenance = new Maintenance();
        $maintenance->user_id = $validated['user_id'];
        $maintenance->block_number = $user->block_number; // Get the block number from the user table
        $maintenance->owner_name = $user->first_name . ' ' . $user->last_name; // Set the owner name
        $maintenance->block = substr($user->block_number, 0, 1); // Derive the block from block_number
        $maintenance->amount = $validated['amount'];
        $maintenance->date = $validated['date'];
        $maintenance->description = $validated['description'];
        $maintenance->maintenance_status = $maintenanceStatus;
        $maintenance->status = $validated['status'] ?? 'active'; // Default to active
        $maintenance->photo = $validated['photo'] ?? "profile_photos/avatar.png"; // If no photo provided, set it as null
        $maintenance->save();
        $maintenance->society_id = auth()->user()->society_id;

        // Return the created maintenance record
        return response()->json([
            'status' => true,
            'message' => 'Maintenance record created successfully',
            'data' => $maintenance
        ], 201); // Return 201 for successfully created resource
    }



    // Update a maintenance record
    public function update(Request $request)
    {
        $id = $request->input('id');
        if (!$id) {
            return response()->json([
                'status' => false,
                'message' => 'ID is required',
                'data' => []
            ], 200);
        }

        $maintenance = Maintenance::find($id);
        if (!$maintenance) {
            return response()->json([
                'status' => false,
                'message' => 'Maintenance record not found',
                'data' => []
            ], 200);
        }

        $validatedData = $request->validate([
            'block_number' => 'nullable|string|max:50',
            'maintenance_status' => 'nullable|in:PENDING,COMPLETED',
            'block' => 'nullable|string|max:50',
            'photo' => 'nullable|string|max:256',
            'user_id' => 'nullable|exists:users,id',
            'amount' => 'nullable|integer',
            'date' => 'nullable|date',
            'description' => 'nullable|string',
            'status' => 'nullable|in:active,deactive',
        ]);

        // If user_id is updated, also update owner_name
        if (isset($validatedData['user_id'])) {
            $user = User::findOrFail($validatedData['user_id']);
            $validatedData['owner_name'] = $user->first_name . ' ' . $user->last_name;
        }

        $maintenance->update($validatedData);
        $maintenance->society_id = auth()->user()->society_id;

        return response()->json([
            'status' => true,
            'message' => 'Maintenance record updated successfully',
            'data' => $maintenance
        ], 200);
    }

    // Remove a maintenance record by ID
    public function destroy(Request $request)
    {
        $id = $request->input('id');
        if (!$id) {
            return response()->json([
                'status' => false,
                'message' => 'ID is required',
                'data' => []
            ], 200);
        }

        $maintenance = Maintenance::find($id);
        if (!$maintenance) {
            return response()->json([
                'status' => false,
                'message' => 'Maintenance record not found',
                'data' => []
            ], 200);
        }

        $maintenance->delete();

        return response()->json([
            'status' => true,
            'message' => 'Maintenance record deleted successfully',
            'data' => []
        ], 200);
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
}