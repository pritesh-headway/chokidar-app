<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VehicleController extends Controller
{
    // Store a newly created vehicle
    // Store a new vehicle
    public function store(Request $request)
    {
        // Ensure the logged-in user's id matches the user_id in the request
        if (auth()->user()->id !== (int)$request->user_id) {
            return response()->json([
                'status' => false,
                'message' => 'You are not authorized to add vehicles for other users',
                'data' => []
            ], 200);
        }

        // Validate incoming request
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'vehicle_number' => 'required|string',
            'vehicle_type' => 'required|in:2-wheeler,4-wheeler',
            'vehicle_brand' => 'nullable|string|max:255',
            'vehicle_model' => 'nullable|string|max:255',
            'status' => 'nullable|in:active,deactive',
        ]);

        // Check if a vehicle with the same vehicle number already exists for the user
        $existingVehicle = Vehicle::where('user_id', $request->user_id)
            ->where('vehicle_number', $request->vehicle_number)
            ->first();

        if ($existingVehicle) {
            return response()->json([
                'status' => false,
                'message' => 'This vehicle number is already registered for this user.',
                'data' => []
            ], 409); // HTTP status code 409 for conflict (duplicate entry)
        }

        // Fetch the block_number from the users table using user_id
        $user = User::findOrFail($request->user_id);
        $blockNumber = $user->block_number;

        // Create the vehicle with the block_number included
        $vehicle = Vehicle::create([
            'user_id' => $request->user_id,
            'vehicle_number' => $request->vehicle_number,
            'vehicle_type' => $request->vehicle_type,
            'vehicle_brand' => $request->vehicle_brand,
            'vehicle_model' => $request->vehicle_model,
            'status' => $request->status ?? "active",
            'block_number' => $blockNumber,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Vehicle created successfully',
            'data' => $vehicle
        ], 201); // HTTP status code 201 for created
    }



    // Update the specified vehicle
    // Update the specified vehicle
    // public function update(Request $request)
    // {
    //     // dd(auth()->user()->id);
    //     // Ensure the logged-in user's id matches the user_id of the vehicle
    //     if (auth()->user()->id !== (int)$request->user_id) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'You are not authorized to update this vehicle. The user ID does not match the logged-in user.',
    //             'data' => []
    //         ], 403); // HTTP status code 403 for forbidden
    //     }

    //     // Validate incoming request
    //     $validator = \Validator::make($request->all(), [
    //         'id' => 'required|exists:vehicles,id',
    //         // 'user_id' => 'required|exists:users,id', // Ensure user_id exists
    //         'vehicle_number' => 'nullable|string',
    //         'vehicle_type' => 'nullable|in:2-wheeler,4-wheeler',
    //         'status' => 'nullable|in:active,deactive',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Validation failed.',
    //             'errors' => $validator->errors()
    //         ], 422); // HTTP status code 422 for validation error
    //     }

    //     // Find the vehicle
    //     $vehicle = Vehicle::findOrFail($request->id);

    //     // If the vehicle belongs to a different user, return an error
    //     if ($vehicle->user_id !== (int)$request->user_id) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'The vehicle does not belong to the specified user.',
    //             'data' => []
    //         ], 403); // Forbidden error
    //     }

    //     // Only update the fields that are provided
    //     $vehicle->update($request->only(['user_id', 'vehicle_number', 'vehicle_type', 'status']));

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Vehicle updated successfully',
    //         'data' => $vehicle
    //     ]);
    // }

    // Update the specified vehicle
    public function update(Request $request)
    {
        // Validate incoming request
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:vehicles,id',
            'vehicle_number' => 'nullable|string',
            'vehicle_type' => 'nullable|in:2-wheeler,4-wheeler',
            'vehicle_brand' => 'nullable|string|max:255',
            'vehicle_model' => 'nullable|string|max:255',
            'status' => 'nullable|in:active,deactive',
        ]);

        // Return validation errors if validation fails
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors()
            ], 422); // HTTP status code 422 for validation error
        }

        // Find the vehicle
        $vehicle = Vehicle::findOrFail($request->id);

        // // Ensure the logged-in user's id matches the user_id of the vehicle
        // if (auth()->user()->id !== $vehicle->user_id) {
        //     return response()->json([
        //         'status' => false,
        //         'message' => 'You are not authorized to update this vehicle. The user ID does not match the logged-in user.',
        //         'data' => []
        //     ], 403); // HTTP status code 403 for forbidden
        // }

        // Only update the fields that are provided in the request
        $vehicle->update($request->only([
            'vehicle_number',
            'vehicle_type',
            'vehicle_brand',
            'vehicle_model',
            'status'
        ]));

        return response()->json([
            'status' => true,
            'message' => 'Vehicle updated successfully',
            'data' => $vehicle
        ]);
    }



    // Remove the specified vehicle
    // Remove the specified vehicle
    public function destroy(Request $request)
    {
        // Validate the incoming request to ensure the vehicle exists
        $request->validate([
            'id' => 'required|exists:vehicles,id',
        ]);

        // Fetch the vehicle
        $vehicle = Vehicle::find($request->id);

        // If vehicle is not found (should never reach here because of validation)
        if (!$vehicle) {
            return response()->json([
                'status' => false,
                'message' => 'Vehicle not found.',
                'data' => []
            ], 200);
        }

        // Check if the logged-in user is the vehicle's owner or an admin
        if ($vehicle->user_id !== (int)auth()->user()->id && auth()->user()->role_id !== 2) {
            return response()->json([
                'status' => false,
                'message' => 'You are not authorized to delete this vehicle.',
                'data' => []
            ], 200); // Forbidden status code
        }

        // Soft delete the vehicle
        $vehicle->delete();

        return response()->json([
            'status' => true,
            'message' => 'Vehicle successfully deleted.',
            'data' => []
        ], 200); // No content, as the vehicle is successfully deleted
    }



    // Fetch vehicles for a given user by id
    // Fetch vehicles for a given user by id or all vehicles if 'user_id' is "all"
    // public function index(Request $request)
    // {
    //     // Get user_id from request body
    //     $userId = $request->input('user_id');

    //     // If user_id is "all" or not provided, return all vehicles
    //     if (!$userId || $userId == "all") {
    //         $vehicles = Vehicle::all()->sortBy('block_number'); // Sorting by block_number in ascending order

    //         if ($vehicles->isEmpty()) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'No vehicles found',
    //                 'data' => []
    //             ], 404);  // If no vehicles found
    //         }

    //         // Group vehicles by block prefix (e.g., "A", "B", "C", etc.)
    //         $groupedVehicles = $vehicles->groupBy(function ($vehicle) {
    //             return strtoupper(substr($vehicle->block_number, 0, 1)); // Get first letter of block_number
    //         });

    //         // Format the response with block titles and rows, using strict format with images
    //         $response = $groupedVehicles->map(function ($vehiclesInBlock, $blockPrefix) {
    //             return [
    //                 'title' => 'Block-' . $blockPrefix, // Set title as "Block-A", "Block-B", etc.
    //                 'rows' => $vehiclesInBlock->map(function ($vehicle, $index) {
    //                     return [
    //                         'no' => $index + 1,
    //                         'blockNumber' => $vehicle->block_number,
    //                         'image' => $this->getImageForVehicle($vehicle), // Get image based on vehicle type
    //                         'vehicleNumber' => $vehicle->vehicle_number,
    //                         'type' => ucfirst(strtolower($vehicle->vehicle_type)), // Ensure type is capitalized correctly
    //                     ];
    //                 })
    //             ];
    //         });

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'All vehicles fetched successfully',
    //             'data' => $response->values() // Ensure the array is indexed starting from 0
    //         ]);
    //     }

    //     // Validate if the user exists when user_id is provided
    //     if ($userId) {
    //         $user = User::find($userId);

    //         if (!$user) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'User not found',
    //                 'data' => []
    //             ], 404);  // Return error if user does not exist
    //         }

    //         // Get the vehicles for the given user_id and sort by block_number
    //         $vehicles = Vehicle::where('user_id', $userId)->get()->sortBy('block_number');

    //         if ($vehicles->isEmpty()) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'No vehicles found for this user',
    //                 'data' => []
    //             ], 404);  // If no vehicles found for the user
    //         }

    //         // Group vehicles by block prefix (e.g., "A", "B", "C", etc.)
    //         $groupedVehicles = $vehicles->groupBy(function ($vehicle) {
    //             return strtoupper(substr($vehicle->block_number, 0, 1)); // Get first letter of block_number
    //         });

    //         // Format the response with block titles and rows, using strict format with images
    //         $response = $groupedVehicles->map(function ($vehiclesInBlock, $blockPrefix) {
    //             return [
    //                 'title' => 'Block-' . $blockPrefix, // Set title as "Block-A", "Block-B", etc.
    //                 'rows' => $vehiclesInBlock->map(function ($vehicle, $index) {
    //                     return [
    //                         'no' => $index + 1,
    //                         'blockNumber' => $vehicle->block_number,
    //                         'image' => $this->getImageForVehicle($vehicle), // Get image based on vehicle type
    //                         'vehicleNumber' => $vehicle->vehicle_number,
    //                         'type' => ucfirst(strtolower($vehicle->vehicle_type)), // Ensure type is capitalized correctly
    //                     ];
    //                 })
    //             ];
    //         });

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Vehicles fetched successfully',
    //             'data' => $response->values() // Ensure the array is indexed starting from 0
    //         ]);
    //     }

    //     return response()->json([
    //         'status' => false,
    //         'message' => 'User ID is required',
    //         'data' => []
    //     ], 400);  // Return error if neither "all" nor "user_id" is provided
    // }

    // // Helper function to get the image based on vehicle type
    // private function getImageForVehicle($vehicle)
    // {
    //     // Define images based on vehicle types (defaults for 2-wheeler and 4-wheeler)
    //     $images = [
    //         '2-Wheeler' => 'http://192.168.1.17/chokidar/public/storage/vehicles/logo.png', // Example default image
    //         '4-Wheeler' => 'http://192.168.1.17/chokidar/public/storage/vehicles/india_flag.png', // Example default image
    //     ];

    //     // Return image URL based on vehicle type, default to "logo" image if not found
    //     return $images[$vehicle->vehicle_type] ?? 'http://192.168.1.17/chokidar/public/storage/vehicles/logo.png'; // Default image
    // }

    // public function index(Request $request)
    // {
    //     $query = Vehicle::query();

    //     // Check if 'id' or 'user_id' is provided and apply the appropriate filters
    //     if ($request->has('id') && $request->id !== 'all') {
    //         $query->where('id', $request->id);
    //     } elseif ($request->has('user_id') && $request->user_id !== 'all') {
    //         $query->where('user_id', $request->user_id);
    //     }

    //     // If 'all' is given for either 'id' or 'user_id', return all vehicles
    //     if ($request->id === 'all' || $request->user_id === 'all') {
    //         $vehicles = $query->get();
    //     } else {
    //         $vehicles = $query->get();
    //     }

    //     // Group the vehicles by the first letter of the block_number
    //     $grouped = $vehicles->groupBy(function ($vehicle) {
    //         return strtoupper(substr($vehicle->block_number, 0, 1)); // Group by the first letter of block_number
    //     });

    //     // Sort the groups alphabetically
    //     $sortedGrouped = $grouped->sortKeys();

    //     // Prepare the final response in the desired format
    //     $response = $sortedGrouped->map(function ($rows, $title) {
    //         return [
    //             'title' => 'Block-' . $title, // Format the title as "Block-A", "Block-B", etc.
    //             'rows' => $rows->map(function ($vehicle, $index) {
    //                 // Assigning a placeholder image based on vehicle type or another logic
    //                 // $image = $vehicle->vehicle_type == '2-Wheeler' ? 'https://example.com/images/logo.png' : 'https://example.com/images/india_flag.png';

    //                 return [
    //                     'no' => $index + 1,
    //                     'id' => $vehicle->id,
    //                     'user_id' => $vehicle->user_id,
    //                     'blockNumber' => $vehicle->block_number,
    //                     // 'image' => $image, // Placeholder or dynamically assigned image
    //                     'vehicleNumber' => $vehicle->vehicle_number,
    //                     'type' => $vehicle->vehicle_type,
    //                 ];
    //             })->toArray(),
    //         ];
    //     });

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Vehicles retrieved successfully',
    //         'data' => $response->values()->toArray(),
    //     ]);
    // }

    public function index(Request $request)
    {
        // Get the logged-in user's society_id
        $loggedInUser = auth()->user();
        $loggedInSocietyId = $loggedInUser->society_id;

        // Get all user IDs that belong to the same society_id as the logged-in user
        $userIdsInSameSociety = \App\Models\User::where('society_id', $loggedInSocietyId)->pluck('id');

        // Query the vehicles table
        $query = Vehicle::whereIn('user_id', $userIdsInSameSociety);

        // Check if 'id' or 'user_id' is provided and apply the appropriate filters
        if ($request->has('id') && $request->id !== 'all') {
            $query->where('id', $request->id);
        } elseif ($request->has('user_id') && $request->user_id !== 'all') {
            $query->where('user_id', $request->user_id);
        }

        // If 'all' is given for either 'id' or 'user_id', return all vehicles
        $vehicles = $query->get();

        // Group the vehicles by the first letter of the block_number
        $grouped = $vehicles->groupBy(function ($vehicle) {
            return strtoupper(substr($vehicle->block_number, 0, 1)); // Group by the first letter of block_number
        });

        // Sort the groups alphabetically
        $sortedGrouped = $grouped->sortKeys();

        // Prepare the final response in the desired format
        $response = $sortedGrouped->map(function ($rows, $title) {
            return [
                'title' => 'Block-' . $title, // Format the title as "Block-A", "Block-B", etc.
                'rows' => $rows->map(function ($vehicle, $index) {
                    return [
                        'no' => $index + 1,
                        'id' => $vehicle->id,
                        'user_id' => $vehicle->user_id,
                        'blockNumber' => $vehicle->block_number,
                        'vehicleNumber' => $vehicle->vehicle_number,
                        'type' => $vehicle->vehicle_type,
                        'brand' => $vehicle->vehicle_brand, // Added vehicle_brand
                        'model' => $vehicle->vehicle_model, // Added vehicle_model
                    ];
                })->toArray(),
            ];
        });

        return response()->json([
            'status' => true,
            'message' => 'Vehicles retrieved successfully',
            'data' => $response->values()->toArray(),
        ]);
    }
}
