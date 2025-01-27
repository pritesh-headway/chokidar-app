<?php

namespace App\Http\Controllers;

use App\Models\Maintenance;
use App\Models\User;
use Illuminate\Http\Request;

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
    public function index(Request $request)
    {
        // Get the logged-in user's society_id
        $loggedInSocietyId = auth()->user()->society_id;

        // Fetch the last pending maintenance record per user_id within the same society
        $pendingRecords = Maintenance::select('id', 'block_number', 'user_id', 'owner_name', 'amount', 'date', 'description', 'maintenance_status', 'photo')
            ->where('maintenance_status', 'Pending')
            ->whereHas('user', function ($query) use ($loggedInSocietyId) {
                $query->where('society_id', $loggedInSocietyId);
            })
            ->orderBy('id', 'desc')
            ->get()
            ->keyBy('user_id');

        // Fetch the last completed maintenance record per user_id where no pending records exist, within the same society
        $completedRecords = Maintenance::select('id', 'block_number', 'user_id', 'owner_name', 'amount', 'date', 'description', 'maintenance_status', 'photo')
            ->whereNotIn('user_id', $pendingRecords->keys())
            ->whereHas('user', function ($query) use ($loggedInSocietyId) {
                $query->where('society_id', $loggedInSocietyId);
            })
            ->orderBy('id', 'desc')
            ->get()
            ->keyBy('user_id');

        // Merge both pending and completed records ensuring only one record per user_id
        $allRecords = $pendingRecords->union($completedRecords);

        // Group records by the first letter of block_number
        $groupedRecords = $allRecords->groupBy(function ($record) {
            return strtoupper(substr($record->block_number, 0, 1));
        });

        // Format the response to match the specified structure
        $response = $groupedRecords->map(function ($records, $blockLetter) {
            return [
                'title' => "Block-" . $blockLetter,  // Ensure block title format "Block-A", "Block-B", etc.
                'rows' => $records->values()->map(function ($record, $index) {
                    $date = \Carbon\Carbon::parse($record->date);  // Convert string to Carbon instance
                    return [
                        'no' => $index + 1,
                        'id' => $record->id,
                        'user_id' => $record->user_id,
                        'blockNumber' => $record->block_number,
                        'image' => config('app.url') . '/public/storage/' . $record->photo,  // Generate image URL
                        'ownerName' => $record->owner_name,
                        'maintenance_status' => $record->maintenance_status,
                        // Uncomment as needed for additional fields
                        // 'amount' => (string)$record->amount,
                        // 'date' => $date->format('d/m/Y'),
                        // 'description' => $record->description,
                    ];
                })->toArray(),
            ];
        });

        // Sort the response by block title alphabetically
        $sortedResponse = $response->sortBy('title')->values();

        // Return the response with grouped, formatted, and sorted data
        return response()->json([
            'status' => true,
            'message' => 'Maintenance records fetched successfully',
            'data' => $sortedResponse->toArray(),
        ], 200);
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
        $maintenanceQuery = Maintenance::query();

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
                    'image' => config('app.url') . '/public/storage/' . $record->photo, // You can change this to dynamic image logic
                    'ownerName' => $record->owner_name,
                    'amount' => (string)$record->amount,  // Ensure amount is in string format
                    'maintenance_status' => $record->maintenance_status,
                    'date' => \Carbon\Carbon::parse($date)->format('d-m-Y'),  // Format date
                    'description' => $record->description,
                    'status' => ucfirst(strtolower($record->maintenance_status)),  // Capitalize status correctly
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
            'photo' => 'nullable|string|max:256', // photo is optional
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
        $maintenance->photo = $validated['photo'] ?? null; // If no photo provided, set it as null
        $maintenance->save();

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
}
