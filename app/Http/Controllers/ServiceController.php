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

    // Get a specific service by id
    public function show(Request $request)
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

        // Return full URL for the service image
        $service->service_image = env('APP_URL') . '/public/storage/' . $service->service_image;

        return response()->json([
            'status' => true,
            'message' => 'Service retrieved successfully',
            'data' => $service,
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
