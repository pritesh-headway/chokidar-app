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
        $serviceImagePath = 'service_images/service1.png';

        $service = Service::create([
            'service_name' => $request->service_name,
            'service_type' => $request->service_type,
            'status' => $request->status ?: 'active',
            'service_image' => $serviceImagePath,
        ]);
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
        $service->service_image = 'service_images/service1.png';
        $service->update($request->only('service_name', 'service_type', 'status'));
        $service->service_image = env('APP_URL') . '/public/storage/' . $service->service_image;

        return response()->json([
            'status' => true,
            'message' => 'Service updated successfully',
            'data' => $service,
        ], 200);
    }
    public function index(Request $request)
    {
        $services = Service::all();
        $data = $services->map(function ($service, $index) {
            $service->no = $index + 1;
            // $service->service_image = env('APP_URL') . '/public/storage/' . $service->service_image;
            $service->service_image = asset('storage/' . $service->service_image);
            // dd($service->service_image);
            return $service;
        });
        return response()->json([
            'status' => true,
            'message' => 'Services retrieved successfully',
            'data' => $data,
        ], 200);
    }
    public function show(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'nullable|exists:services,id',
            'service_type' => 'nullable|in:society,owner,both',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'data' => $validator->errors(),
            ], 200);
        }
        $query = Service::query();
        if ($request->has('id')) {
            $service = $query->where('id', $request->id)->first();

            if (!$service) {
                return response()->json([
                    'status' => false,
                    'message' => 'Service not found',
                    'data' => [],
                ], 404);
            }
            $service->no = 1;
            $service->service_image = env('APP_URL') . '/public/storage/' . $service->service_image;

            return response()->json([
                'status' => true,
                'message' => 'Service retrieved successfully',
                'data' => $service,
            ], 200);
        }
        if ($request->has('service_type')) {
            $services = $query->where('service_type', $request->service_type)->get();

            if ($services->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'No services found for the provided service type',
                    'data' => [],
                ], 200);
            }
            $services->each(function ($service, $index) {
                $service->no = $index + 1;
                $service->service_image = env('APP_URL') . '/public/storage/' . $service->service_image;
            });

            return response()->json([
                'status' => true,
                'message' => 'Services retrieved successfully',
                'data' => $services,
            ], 200);
        }
        $services = $query->get();
        $services->each(function ($service, $index) {
            $service->no = $index + 1;
            $service->service_image = env('APP_URL') . '/public/storage/' . $service->service_image;
        });

        return response()->json([
            'status' => true,
            'message' => 'All services retrieved successfully',
            'data' => $services,
        ], 200);
    }
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
