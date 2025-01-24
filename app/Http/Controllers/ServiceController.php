<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'service_name' => 'required|string|max:255',
            'service_type' => 'required|in:society,owner,both',
            'status' => 'nullable|in:active,deactive',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'data' => $validator->errors(),
            ], 200);
        }

        // Use the predefined image for service_image
        $serviceImagePath = 'service_images/service1.png';

        $service = Service::create([
            'service_name' => $request->service_name,
            'service_type' => $request->service_type,
            'status' => $request->status ?: 'active', // Default to 'active' if not provided
            'service_image' => $serviceImagePath,
        ]);

        // Return full URL for the service image
        $service->service_image = env('APP_URL') . '/public/storage/' . $serviceImagePath;

        return response()->json([
            'status' => true,
            'message' => 'Service created successfully',
            'data' => $service,
        ], 201);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:services,id',
            'service_name' => 'nullable|string|max:255',
            'service_type' => 'nullable|in:society,owner,both',
            'status' => 'nullable|in:active,deactive',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'data' => $validator->errors(),
            ], 200);
        }

        $service = Service::find($request->id);

        // Keep the same predefined image for service_image
        $service->service_image = 'service_images/service1.png';
        $service->update($request->only('service_name', 'service_type', 'status'));

        // Return full URL for the service image
        $service->service_image = env('APP_URL') . '/public/storage/' . $service->service_image;

        return response()->json([
            'status' => true,
            'message' => 'Service updated successfully',
            'data' => $service,
        ], 200);
    }

    // Get all services with "no" indexing
    public function index(Request $request)
    {
        $services = Service::all();

        // Add 'no' for indexing and full URL for service_image
        $services = $services->map(function ($service, $index) {
            $service->no = $index + 1;
            $service->service_image = env('APP_URL') . '/public/storage/' . $service->service_image;
            return $service;
        });



        return response()->json([
            'status' => true,
            'message' => 'Services retrieved successfully',
            'data' => $services,
        ], 200);
    }
    public function show(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'nullable|exists:services,id', // 'id' is optional, but must exist if provided
            'service_type' => 'nullable|in:society,owner,both', // 'service_type' is optional and validated if provided
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'data' => $validator->errors(),
            ], 200);
        }

        // Start building the query
        $query = Service::query();

        // If 'id' is provided, filter by 'id' (single service)
        if ($request->has('id')) {
            $service = $query->where('id', $request->id)->first();

            if (!$service) {
                return response()->json([
                    'status' => false,
                    'message' => 'Service not found',
                    'data' => [],
                ], 404);
            }

            // Add "no" index along with the id
            $service->no = 1; // Since only one service is returned, index is 1
            $service->service_image = env('APP_URL') . '/public/storage/' . $service->service_image;

            return response()->json([
                'status' => true,
                'message' => 'Service retrieved successfully',
                'data' => $service,
            ], 200);
        }

        // If 'service_type' is provided, filter by 'service_type' (multiple services)
        if ($request->has('service_type')) {
            $services = $query->where('service_type', $request->service_type)->get();

            if ($services->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'No services found for the provided service type',
                    'data' => [],
                ], 200);
            }

            // Add "no" index along with the id for each service
            $services->each(function ($service, $index) {
                $service->no = $index + 1; // Index starts from 1 (not 0)
                $service->service_image = env('APP_URL') . '/public/storage/' . $service->service_image;
            });

            return response()->json([
                'status' => true,
                'message' => 'Services retrieved successfully',
                'data' => $services,
            ], 200);
        }

        // If neither 'id' nor 'service_type' is provided, return all services
        $services = $query->get();

        // Add "no" index along with the id for each service
        $services->each(function ($service, $index) {
            $service->no = $index + 1; // Index starts from 1 (not 0)
            $service->service_image = env('APP_URL') . '/public/storage/' . $service->service_image;
        });

        return response()->json([
            'status' => true,
            'message' => 'All services retrieved successfully',
            'data' => $services,
        ], 200);
    }



    // Delete a service
    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:services,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'data' => $validator->errors(),
            ], 200);
        }

        $service = Service::find($request->id);
        $service->delete();

        return response()->json([
            'status' => true,
            'message' => 'Service deleted successfully',
        ], 200);
    }
}
