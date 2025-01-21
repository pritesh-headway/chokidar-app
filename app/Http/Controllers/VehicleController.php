<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\User;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    // Store a newly created vehicle
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'vehicle_number' => 'required|string',
            'vehicle_type' => 'required|in:2-wheeler,4-wheeler',
            // 'vehicle_image' => 'nullable|string',
            'status' => 'nullable|in:active,deactive',
        ]);

        // Fetch the block_number from the users table using user_id
        $user = User::findOrFail($request->user_id);
        $blockNumber = $user->block_number;

        // Create the vehicle with the block_number included
        $vehicle = Vehicle::create([
            'user_id' => $request->user_id,
            'vehicle_number' => $request->vehicle_number,
            'vehicle_type' => $request->vehicle_type,
            // 'vehicle_image' => $request->vehicle_image,
            'status' => $request->status,
            'block_number' => $blockNumber,
        ]);

        return response()->json($vehicle, 201);
    }

    // Update the specified vehicle
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:vehicles,id',
            'vehicle_number' => 'nullable|string',
            'vehicle_type' => 'nullable|in:2-wheeler,4-wheeler',
            // 'vehicle_image' => 'nullable|string',
            'status' => 'nullable|in:active,deactive',
        ]);

        $vehicle = Vehicle::findOrFail($request->id);
        $vehicle->update($request->only(['vehicle_number', 'vehicle_type', 'vehicle_image', 'status']));

        return response()->json($vehicle);
    }

    // Remove the specified vehicle
    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:vehicles,id',
        ]);

        $vehicle = Vehicle::findOrFail($request->id);
        $vehicle->delete();

        return response()->json(['message' => 'Successfully deleted the vehicle.'], 204);
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

    public function index(Request $request)
    {
        $query = Vehicle::query();

        // Check if 'id' or 'user_id' is provided and apply the appropriate filters
        if ($request->has('id') && $request->id !== 'all') {
            $query->where('id', $request->id);
        } elseif ($request->has('user_id') && $request->user_id !== 'all') {
            $query->where('user_id', $request->user_id);
        }

        // If 'all' is given for either 'id' or 'user_id', return all vehicles
        if ($request->id === 'all' || $request->user_id === 'all') {
            $vehicles = $query->get();
        } else {
            $vehicles = $query->get();
        }

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
                    // Assigning a placeholder image based on vehicle type or another logic
                    // $image = $vehicle->vehicle_type == '2-Wheeler' ? 'https://example.com/images/logo.png' : 'https://example.com/images/india_flag.png';

                    return [
                        'no' => $index + 1,
                        'id' => $vehicle->id,
                        'user_id' => $vehicle->user_id,
                        'blockNumber' => $vehicle->block_number,
                        // 'image' => $image, // Placeholder or dynamically assigned image
                        'vehicleNumber' => $vehicle->vehicle_number,
                        'type' => $vehicle->vehicle_type,
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
