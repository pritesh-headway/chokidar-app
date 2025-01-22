<?php


// app/Http/Controllers/ServiceProviderController.php

namespace App\Http\Controllers;

use App\Models\ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceProviderController extends Controller
{
    // Helper function to add full URL for images and documents
    protected function addFullImageUrl($serviceProvider)
    {
        // Add full URL for profile image if it exists
        if ($serviceProvider->profile_image) {
            $serviceProvider->profile_image = url('storage/' . $serviceProvider->profile_image);
        }

        // Add full URL for documents if they exist
        if ($serviceProvider->documents) {
            // Ensure 'documents' is an array or empty array
            $documents = is_string($serviceProvider->documents) ? json_decode($serviceProvider->documents, true) : $serviceProvider->documents;

            // If the documents field is null or empty, default it to an empty array
            if (is_null($documents)) {
                $documents = [];
            }

            // Map document URLs
            $serviceProvider->documents = array_map(function ($document) {
                return url('storage/service_provider_documents/' . $document);
            }, $documents);
        }

        return $serviceProvider;
    }


    // Store a new service provider
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'service_id' => 'required|exists:services,id',
            'mobile' => 'required|digits:10',
            'address' => 'required|string',
            'profile_image' => 'required|string',
            'documents' => 'nullable|array',  // Allow documents to be null or an array
            'status' => 'nullable|in:active,deactive',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'data' => $validator->errors(),
            ], 200);
        }

        // Ensure documents is an array, even if null or not provided
        $documents = $request->has('documents') ? json_encode($request->documents) : json_encode([]);

        // Create the service provider
        $serviceProvider = ServiceProvider::create([
            'full_name' => $request->full_name,
            'service_id' => $request->service_id,
            'mobile' => $request->mobile,
            'address' => $request->address,
            'profile_image' => $request->profile_image,
            'documents' => $documents,
            'status' => $request->status ?: 'active',
        ]);

        // Add full URLs for profile image and documents
        $serviceProvider = $this->addFullImageUrl($serviceProvider);

        return response()->json([
            'status' => true,
            'message' => 'Service provider created successfully',
            'data' => $serviceProvider,
        ], 200);
    }


    // Get all service providers
    public function index(Request $request)
    {
        $serviceProviders = ServiceProvider::all();
        $serviceProviders = $serviceProviders->map(function ($provider) {
            // Add full URLs for profile image and documents
            return $this->addFullImageUrl($provider);
        });

        return response()->json([
            'status' => true,
            'message' => 'Service providers retrieved successfully',
            'data' => $serviceProviders,
        ], 200);
    }

    // Get a specific service provider
    public function show(Request $request)
    {
        // Validation for either 'id' or 'service_id'
        $validator = Validator::make($request->all(), [
            'id' => 'nullable|exists:service_providers,id',
            'service_id' => 'nullable|exists:services,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'data' => $validator->errors(),
            ], 200);
        }

        // Check if 'id' is provided
        if ($request->has('id') && $request->id != null) {
            $serviceProvider = ServiceProvider::find($request->id);

            if (!$serviceProvider) {
                return response()->json([
                    'status' => false,
                    'message' => 'Service provider not found',
                ], 404);
            }

            // Add full URLs for profile image and documents
            $serviceProvider = $this->addFullImageUrl($serviceProvider);

            return response()->json([
                'status' => true,
                'message' => 'Service provider retrieved successfully',
                'data' => $serviceProvider,
            ], 200);
        }

        // Check if 'service_id' is provided
        if ($request->has('service_id') && $request->service_id != null) {
            $serviceProviders = ServiceProvider::where('service_id', $request->service_id)->get();

            if ($serviceProviders->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'No service providers found for this service_id',
                ], 404);
            }

            // Add full URLs for profile images and documents for each service provider
            $serviceProviders = $serviceProviders->map(function ($provider) {
                return $this->addFullImageUrl($provider);
            });

            return response()->json([
                'status' => true,
                'message' => 'Service providers retrieved successfully',
                'data' => $serviceProviders,
            ], 200);
        }

        // If neither 'id' nor 'service_id' is provided, return an error
        return response()->json([
            'status' => false,
            'message' => 'Please provide either an id or service_id.',
        ], 400);
    }


    // Update a service provider
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:service_providers,id',
            'full_name' => 'nullable|string|max:255',
            'service_id' => 'nullable|exists:services,id',
            'mobile' => 'nullable|digits:10',
            'address' => 'nullable|string',
            'profile_image' => 'nullable|string',
            'documents' => 'nullable|array',
            'status' => 'nullable|in:active,deactive',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'data' => $validator->errors(),
            ], 200);
        }

        $serviceProvider = ServiceProvider::find($request->id);
        $serviceProvider->update($request->only('full_name', 'service_id', 'mobile', 'address', 'profile_image', 'documents', 'status'));

        // Add full URLs for profile image and documents
        $serviceProvider = $this->addFullImageUrl($serviceProvider);

        return response()->json([
            'status' => true,
            'message' => 'Service provider updated successfully',
            'data' => $serviceProvider,
        ], 200);
    }

    // Delete a service provider
    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:service_providers,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'data' => $validator->errors(),
            ], 200);
        }

        $serviceProvider = ServiceProvider::find($request->id);
        $serviceProvider->delete();

        return response()->json([
            'status' => true,
            'message' => 'Service provider deleted successfully',
        ], 200);
    }
}
