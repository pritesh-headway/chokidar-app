<?php

namespace App\Http\Controllers;

use App\Models\Maintenance;
use App\Models\User;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{

    // public function index(Request $request)
    // {
    //     $userId = $request->input('user_id');

    //     $maintenanceQuery = Maintenance::with(['user:id,society_id,house_id,profile_photo,first_name,last_name', 'user.house:id,block,house_no']);

    //     if ($userId) {
    //         $maintenanceQuery->where('user_id', $userId);
    //     }

    //     $maintenanceRecords = $maintenanceQuery->orderBy('date', 'desc')->get();

    //     if ($maintenanceRecords->isEmpty()) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'No maintenance records found.',
    //             'data' => []
    //         ], 200);
    //     }

    //     $groupedRecords = $maintenanceRecords->groupBy('user.house_id');

    //     $response = $groupedRecords->map(function ($records, $houseId) {
    //         $user = $records->first()->user;
    //         $house = $user->house;
    //         $block = $house ? $house->block : null;
    //         $house_no = $house ? $house->house_no : null;
    //         $block_number = $block && $house_no ? $block . '-' . $house_no : null;

    //         return [
    //             'title' => $block,
    //             'rows' => $records->groupBy('user_id')->map(function ($userRecords, $userId) use ($block_number) {
    //                 $user = $userRecords->first()->user;

    //                 return [
    //                     'no' => $userId,
    //                     'user_id' => $userId,
    //                     'blockNumber' => $block_number,
    //                     'image' => $user->profile_photo ? config('app.url') . '/public/storage/' . $user->profile_photo : null,
    //                     'ownerName' => $user->first_name . ' ' . $user->last_name,
    //                     'maintenance_status' => strtoupper($userRecords->first()->maintenance_status),
    //                     'society_id' => $user->society_id,
    //                     'maintenance' => $userRecords->map(function ($record, $index) {
    //                         return [
    //                             'no' => $index + 1,
    //                             'id' => $record->id,
    //                             'amount' => (int) $record->amount,
    //                             'date' => \Carbon\Carbon::parse($record->date)->format('Y-m-d'),
    //                             'maintenance_status' => ucfirst(strtolower($record->maintenance_status)),
    //                         ];
    //                     })->values()->toArray()
    //                 ];
    //             })->values()->toArray()
    //         ];
    //     })->values()->toArray();

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Maintenance records fetched successfully',
    //         'data' => $response
    //     ], 200);
    // }


    public function index(Request $request)
    {
        $userId = $request->input('user_id');

        // Fetch maintenance records with user and house details
        $maintenanceQuery = Maintenance::with([
            'user:id,society_id,house_id,profile_photo,first_name,last_name',
            'user.house:id,block,house_no'
        ]);

        // Filter by user_id if provided
        if ($userId) {
            $maintenanceQuery->where('user_id', $userId);
        }

        // Fetch records
        $maintenanceRecords = $maintenanceQuery->orderBy('date', 'desc')->get();

        if ($maintenanceRecords->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'No maintenance records found.',
                'data' => []
            ], 200);
        }

        // Group records by house_id
        $groupedRecords = $maintenanceRecords->groupBy('user.house_id');

        // Format response
        $response = $groupedRecords->map(function ($records, $houseId) {
            $user = $records->first()->user;
            $house = $user->house;
            $block = $house ? $house->block : null;
            $house_no = $house ? $house->house_no : null;
            $block_number = $block && $house_no ? $block . '-' . $house_no : null;

            return [
                'title' => $block,
                'rows' => $records->groupBy('user_id')->map(function ($userRecords, $userId) use ($block_number) {
                    $user = $userRecords->first()->user;

                    // Check if any maintenance record is "PENDING"
                    $hasPending = $userRecords->contains('maintenance_status', 'PENDING');

                    return [
                        'no' => $userId,
                        'user_id' => $userId,
                        'blockNumber' => $block_number,
                        'image' => $user->profile_photo ? config('app.url') . '/public/storage/' . $user->profile_photo : null,
                        'ownerName' => $user->first_name . ' ' . $user->last_name,
                        'maintenance_status' => $hasPending ? 'PENDING' : 'COMPLETED',
                        'society_id' => $user->society_id,
                        'maintenance' => $userRecords->map(function ($record, $index) {
                            return [
                                'no' => $index + 1,
                                'id' => $record->id,
                                'amount' => (int) $record->amount,
                                'date' => \Carbon\Carbon::parse($record->date)->format('Y-m-d'),
                                'maintenance_status' => ucfirst(strtolower($record->maintenance_status)),
                            ];
                        })->values()->toArray()
                    ];
                })->values()->toArray()
            ];
        })->values()->toArray();

        return response()->json([
            'status' => true,
            'message' => 'Maintenance records fetched successfully',
            'data' => $response
        ], 200);
    }


    public function show(Request $request)
    {
        // Get the 'id' and 'user_id' parameters from the request body
        $id = $request->input('id');
        $userId = $request->input('user_id');

        // Check if either 'id' or 'user_id' is provided
        if (!$id && !$userId) {
            return response()->json([
                'status' => false,
                'message' => 'Please provide either an ID or user_id to fetch records.',
                'data' => []
            ], 200);
        }

        // Fetch maintenance records with user and house details
        $maintenanceQuery = Maintenance::with([
            'user:id,first_name,last_name,society_id,house_id', // Fetch user with house_id
            'user.house:id,block,house_no' // Fetch house details using house_id
        ]);

        // Apply filters
        if ($userId) {
            $maintenanceQuery->where('user_id', $userId);
        }
        if ($id) {
            $maintenanceQuery->where('id', $id);
        }

        // Fetch maintenance records
        $maintenanceRecords = $maintenanceQuery->orderBy('date', 'desc')->get();

        // Check if records exist
        if ($maintenanceRecords->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'No maintenance records found for the specified criteria.',
                'data' => []
            ], 200);
        }

        // Format response
        $response = $maintenanceRecords->map(function ($record, $index) {
            $user = $record->user;
            $house = $user ? $user->house : null;

            return [
                'no' => $index + 1,
                'id' => $record->id,
                'user_id' => $record->user_id,
                'blockNumber' => $house ? ($house->block . '-' . $house->house_no) : null,
                'image' => $record->photo ? config('app.url') . '/public/storage/' . $record->photo : null,
                'ownerName' => $user ? ($user->first_name . ' ' . $user->last_name) : null,
                'amount' => (string)$record->amount,
                'maintenance_status' => $record->maintenance_status,
                'date' => $record->date ? \Carbon\Carbon::parse($record->date)->format('d-m-Y') : null,
                'description' => $record->description,
                'status' => $record->status,
                'society_id' => $user->society_id ?? null,
            ];
        });

        // Return response
        return response()->json([
            'status' => true,
            'message' => 'Maintenance records fetched successfully',
            'data' => $response->toArray()
        ], 200);
    }



    public function store(Request $request)
    {
        $missingArguments = [];
        $requiredFields = ['user_id', 'amount', 'date', 'description'];

        foreach ($requiredFields as $field) {
            if (!$request->has($field)) {
                $missingArguments[] = $field;
            }
        }

        if (!empty($missingArguments)) {
            return response()->json([
                'status' => false,
                'message' => 'Missing required arguments',
                'missing_arguments' => $missingArguments
            ], 200);
        }

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|integer',
            'date' => 'required|date',
            'description' => 'required|string',
        ]);

        $user = User::with('house')->find($validated['user_id']);
        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User not found'], 200);
        }

        $house = $user->house;
        if (!$house) {
            return response()->json(['status' => false, 'message' => 'House not found for the user'], 200);
        }

        $block = $house->block;
        $house_no = $house->house_no;
        $block_number = $block . '-' . $house_no;
        $owner_name = $user->first_name . ' ' . $user->last_name;

        $maintenance = new Maintenance();
        $maintenance->user_id = $validated['user_id'];
        $maintenance->block = $block;
        $maintenance->block_number = $block_number;
        $maintenance->owner_name = $owner_name;
        $maintenance->amount = $validated['amount'];
        $maintenance->date = $validated['date'];
        $maintenance->description = $validated['description'];
        $maintenance->maintenance_status = 'PENDING';
        $maintenance->status = 'active';
        $maintenance->photo = "profile_photos/avatar.png";
        $maintenance->save();

        // Format response similar to `index()` and `show()`
        $response = [
            'title' => $block_number,
            'rows' => [
                [
                    'no' => $user->id,
                    'user_id' => $user->id,
                    'blockNumber' => $block_number,
                    'image' => $user->profile_photo ? config('app.url') . '/public/storage/' . $user->profile_photo : null,
                    'ownerName' => $owner_name,
                    'maintenance_status' => strtoupper($maintenance->maintenance_status),
                    'society_id' => $user->society_id,
                    'maintenance' => [
                        [
                            'no' => 1,
                            'id' => $maintenance->id,
                            'amount' => (int) $maintenance->amount,
                            'date' => \Carbon\Carbon::parse($maintenance->date)->format('Y-m-d'),
                            'maintenance_status' => ucfirst(strtolower($maintenance->maintenance_status)),
                        ]
                    ]
                ]
            ]
        ];

        return response()->json([
            'status' => true,
            'message' => 'Maintenance record created successfully',
            'data' => $response
        ], 201);
    }


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

        // Validate only allowed fields
        $validatedData = $request->validate([
            'amount' => 'nullable|integer',
            'description' => 'nullable|string',
            'maintenance_status' => 'nullable|in:PENDING,COMPLETED',
        ]);

        // Update only the provided fields
        if (isset($validatedData['amount'])) {
            $maintenance->amount = $validatedData['amount'];
        }
        if (isset($validatedData['description'])) {
            $maintenance->description = $validatedData['description'];
        }
        if (isset($validatedData['maintenance_status'])) {
            $maintenance->maintenance_status = strtoupper($validatedData['maintenance_status']);
        }

        $maintenance->save();

        // Format response to match `index()` and `show()`
        $response = [
            'id' => $maintenance->id,
            'amount' => (int) $maintenance->amount,
            'description' => $maintenance->description,
            'maintenance_status' => strtoupper($maintenance->maintenance_status),
            'updated_at' => $maintenance->updated_at->format('Y-m-d H:i:s')
        ];

        return response()->json([
            'status' => true,
            'message' => 'Maintenance record updated successfully',
            'data' => $response
        ], 200);
    }

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
        $filename = time() . '_' . $file->getClientOriginalName();
        $filename = str_replace(' ', '_', $filename);

        $file->move(public_path("storage/{$folder}"), $filename);
        return "{$folder}/{$filename}";
    }
}
