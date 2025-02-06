<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VehicleController extends Controller
{
    public function store(Request $request)
    {

        if (auth()->user()->id !== (int)$request->user_id) {
            return response()->json([
                'status' => false,
                'message' => 'You are not authorized to add vehicles for other users',
                'data' => []
            ], 200);
        }
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'vehicle_number' => 'required|string',
            'vehicle_type' => 'required|in:2-wheeler,4-wheeler',
            'vehicle_brand' => 'nullable|string|max:255',
            'vehicle_model' => 'nullable|string|max:255',
            'status' => 'nullable|in:active,deactive',
        ]);
        $existingVehicle = Vehicle::where('user_id', $request->user_id)
            ->where('vehicle_number', $request->vehicle_number)
            ->first();

        if ($existingVehicle) {
            return response()->json([
                'status' => false,
                'message' => 'This vehicle number is already registered for this user.',
                'data' => []
            ], 409);
        }
        $user = User::findOrFail($request->user_id);
        $blockNumber = $user->block_number;
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
        ], 201);
    }
    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:vehicles,id',
            'vehicle_number' => 'nullable|string',
            'vehicle_type' => 'nullable|in:2-wheeler,4-wheeler',
            'vehicle_brand' => 'nullable|string|max:255',
            'vehicle_model' => 'nullable|string|max:255',
            'status' => 'nullable|in:active,deactive',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors()
            ], 422);
        }
        $vehicle = Vehicle::findOrFail($request->id);
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
    public function destroy(Request $request)
    {

        $request->validate([
            'id' => 'required|exists:vehicles,id',
        ]);
        $vehicle = Vehicle::find($request->id);
        if (!$vehicle) {
            return response()->json([
                'status' => false,
                'message' => 'Vehicle not found.',
                'data' => []
            ], 200);
        }
        if ($vehicle->user_id !== (int)auth()->user()->id && auth()->user()->role_id !== 2) {
            return response()->json([
                'status' => false,
                'message' => 'You are not authorized to delete this vehicle.',
                'data' => []
            ], 200);
        }
        $vehicle->delete();

        return response()->json([
            'status' => true,
            'message' => 'Vehicle successfully deleted.',
            'data' => []
        ], 200);
    }
    public function index(Request $request)
    {

        $loggedInUser = auth()->user();
        $loggedInSocietyId = $loggedInUser->society_id;
        $userIdsInSameSociety = \App\Models\User::where('society_id', $loggedInSocietyId)->pluck('id');
        $query = Vehicle::whereIn('user_id', $userIdsInSameSociety);
        if ($request->has('id') && $request->id !== 'all') {
            $query->where('id', $request->id);
        } elseif ($request->has('user_id') && $request->user_id !== 'all') {
            $query->where('user_id', $request->user_id);
        }
        $vehicles = $query->get();
        $grouped = $vehicles->groupBy(function ($vehicle) {
            return strtoupper(substr($vehicle->block_number, 0, 1));
        });
        $sortedGrouped = $grouped->sortKeys();
        $response = $sortedGrouped->map(function ($rows, $title) {
            return [
                'title' => 'Block-' . $title,
                'rows' => $rows->map(function ($vehicle, $index) {
                    return [
                        'no' => $index + 1,
                        'id' => $vehicle->id,
                        'user_id' => $vehicle->user_id,
                        'blockNumber' => $vehicle->block_number,
                        'vehicleNumber' => $vehicle->vehicle_number,
                        'type' => $vehicle->vehicle_type,
                        'brand' => $vehicle->vehicle_brand,
                        'model' => $vehicle->vehicle_model,
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
