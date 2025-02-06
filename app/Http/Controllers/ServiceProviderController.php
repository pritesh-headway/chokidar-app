<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Models\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class ServiceProviderController extends Controller
{

    protected function addFullImageUrl($serviceProvider)
    {

        if ($serviceProvider->profile_image) {
            $serviceProvider->profile_image = url('storage/' . $serviceProvider->profile_image);
        }
        if ($serviceProvider->documents) {

            $documents = is_string($serviceProvider->documents) ? json_decode($serviceProvider->documents, true) : $serviceProvider->documents;
            if (is_null($documents)) {
                $documents = [];
            }
            $serviceProvider->documents = array_map(function ($document) {
                return url('storage/service_provider_documents/' . $document);
            }, $documents);
        }

        return $serviceProvider;
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'service_id' => 'required|exists:services,id',
            'mobile' => 'required|digits:10',
            'address' => 'required|string',
            'profile_image' => 'required|string',
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
        $documents = $request->has('documents') ? json_encode($request->documents) : json_encode([]);
        $serviceProvider = ServiceProvider::create([
            'full_name' => $request->full_name,
            'service_id' => $request->service_id,
            'mobile' => $request->mobile,
            'address' => $request->address,
            'profile_image' => $request->profile_image,
            'documents' => $documents,
            'status' => $request->status ?: 'active',
        ]);
        $serviceProvider = $this->addFullImageUrl($serviceProvider);

        return response()->json([
            'status' => true,
            'message' => 'Service provider created successfully',
            'data' => $serviceProvider,
        ], 200);
    }
    public function index(Request $request)
    {
        $serviceProviders = ServiceProvider::all();
        $serviceProviders = $serviceProviders->map(function ($provider, $index) {

            $provider->no = $index + 1;
            return $this->addFullImageUrl($provider);
        });

        return response()->json([
            'status' => true,
            'message' => 'Service providers retrieved successfully',
            'data' => $serviceProviders,
        ], 200);
    }
    public function show(Request $request)
    {

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
        if ($request->has('id') && $request->id != null) {
            $serviceProvider = ServiceProvider::find($request->id);

            if (!$serviceProvider) {
                return response()->json([
                    'status' => false,
                    'message' => 'Service provider not found',
                ], 404);
            }
            $serviceProvider->no = 1;
            $serviceProvider = $this->addFullImageUrl($serviceProvider);

            return response()->json([
                'status' => true,
                'message' => 'Service provider retrieved successfully',
                'data' => $serviceProvider,
            ], 200);
        }
        if ($request->has('service_id') && $request->service_id != null) {
            $serviceProviders = ServiceProvider::where('service_id', $request->service_id)->get();

            if ($serviceProviders->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'No service providers found for this service_id',
                ], 404);
            }
            $serviceProviders = $serviceProviders->map(function ($provider, $index) {
                $provider->no = $index + 1;
                return $this->addFullImageUrl($provider);
            });

            return response()->json([
                'status' => true,
                'message' => 'Service providers retrieved successfully',
                'data' => $serviceProviders,
            ], 200);
        }
        return response()->json([
            'status' => false,
            'message' => 'Please provide either an id or service_id.',
        ], 400);
    }
    public function getByServiceType(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'service_type' => 'required|in:society,owner',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'data' => $validator->errors(),
            ], 200);
        }
        if ($request->service_type == 'society') {
            $serviceIds = Service::whereIn('service_type', ['society', 'both'])->pluck('id');
        } else {
            $serviceIds = Service::whereIn('service_type', ['owner', 'both'])->pluck('id');
        }
        $serviceProviders = ServiceProvider::whereIn('service_id', $serviceIds)->get();

        if ($serviceProviders->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'No service providers found for the given service_type',
            ], 404);
        }
        $serviceProviders = $serviceProviders->map(function ($provider, $index) {
            $provider->no = $index + 1;
            return $this->addFullImageUrl($provider);
        });

        return response()->json([
            'status' => true,
            'message' => 'Service providers retrieved successfully',
            'data' => $serviceProviders,
        ], 200);
    }
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
        $serviceProvider = $this->addFullImageUrl($serviceProvider);

        return response()->json([
            'status' => true,
            'message' => 'Service provider updated successfully',
            'data' => $serviceProvider,
        ], 200);
    }
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
