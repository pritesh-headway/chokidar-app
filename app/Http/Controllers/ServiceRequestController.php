<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceRequest;
use Illuminate\Support\Facades\Validator;

class ServiceRequestController extends Controller
{
    // Fetch all service requests
    public function index(Request $request)
    {
        $serviceRequests = ServiceRequest::all();

        // Add 'no' to each service request
        $serviceRequests->transform(function ($item, $key) {
            $item->no = $key + 1;  // Incremental 'no' starting from 1
            return $item;
        });

        return response()->json([
            'status' => true,
            'message' => 'All service requests retrieved successfully.',
            'data' => $serviceRequests,
        ]);
    }


    // Create a new service request
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'member_id' => 'required|exists:users,id',
            'service_id' => 'required|exists:services,id',
            'provider_id' => 'required|exists:service_providers,id',
            'request_status' => 'nullable|in:pending,completed,cancelled',
            'status' => 'nullable|in:active,deactive',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed.',
                'data' => $validator->errors(),
            ]);
        }

        $serviceRequest = ServiceRequest::create([
            'member_id' => $request->member_id,
            'service_id' => $request->service_id,
            'provider_id' => $request->provider_id,
            'request_status' => $request->request_status ?: 'pending',
            'status' => $request->status ?: 'active',
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Service request created successfully.',
            'data' => $serviceRequest,
        ]);
    }

    public function getServiceRequestsByMemberId(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'member_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed.',
                'data' => $validator->errors(),
            ]);
        }

        $serviceRequests = ServiceRequest::where('member_id', $request->member_id)
            ->with(['service:id,service_name', 'provider:id,full_name,mobile'])
            ->get();

        $serviceRequests->transform(function ($item, $key) {
            return [
                'no' => $key + 1,
                'id' => $item->id,
                'member_id' => $item->member_id,
                'service_name' => optional($item->service)->service_name,
                'provider_name' => optional($item->provider)->full_name,
                'mobile' => optional($item->provider)->mobile,
                'request_status' => $item->request_status,
                'created_at' => $item->created_at->toIso8601String(),
                'updated_at' => $item->updated_at->toIso8601String(),
            ];
        });

        return response()->json([
            'status' => true,
            'message' => 'Service requests retrieved successfully.',
            'data' => $serviceRequests,
        ]);
    }


    // Flexible fetching based on query parameters
    public function show(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'nullable|exists:service_requests,id',
            'member_id' => 'nullable|exists:users,id',
            'service_id' => 'nullable|exists:services,id',
            'provider_id' => 'nullable|exists:service_providers,id',
            'request_status' => 'nullable|in:pending,completed,cancelled',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed.',
                'data' => $validator->errors(),
            ]);
        }

        // Build the query dynamically based on the input
        $query = ServiceRequest::query();

        if ($request->filled('id')) {
            $query->where('id', $request->id);
        }
        if ($request->filled('member_id')) {
            $query->where('member_id', $request->member_id);
        }
        if ($request->filled('service_id')) {
            $query->where('service_id', $request->service_id);
        }
        if ($request->filled('provider_id')) {
            $query->where('provider_id', $request->provider_id);
        }
        if ($request->filled('request_status')) {
            $query->where('request_status', $request->request_status);
        }

        // Get the filtered results
        $serviceRequests = $query->get();

        $serviceRequests->transform(function ($item, $key) {
            $item->no = $key + 1;  // Incremental 'no' starting from 1
            return $item;
        });


        return response()->json([
            'status' => true,
            'message' => 'Service requests retrieved successfully.',
            'data' => $serviceRequests,
        ]);
    }

    // Delete a service request
    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:service_requests,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed.',
                'data' => $validator->errors(),
            ]);
        }

        $serviceRequest = ServiceRequest::find($request->id);
        $serviceRequest->delete();

        return response()->json([
            'status' => true,
            'message' => 'Service request deleted successfully.',
        ]);
    }

    public function update(Request $request)
    {
        // Validate the request input
        $validated = $request->validate([
            'id' => 'required|integer|exists:service_requests,id',
            'member_id' => 'nullable|integer|exists:users,id',
            'service_id' => 'nullable|integer|exists:services,id',
            'provider_id' => 'nullable|integer|exists:service_providers,id',
            'request_status' => 'nullable|in:pending,completed,cancelled',
            'status' => 'nullable|in:active,deactive',
        ]);

        try {
            // Find the service request by ID
            $serviceRequest = ServiceRequest::find($validated['id']);

            if (!$serviceRequest) {
                return response()->json([
                    'status' => false,
                    'message' => 'Service request not found.',
                ], 404);
            }

            // Check for missing parameters
            $missingParams = [];
            foreach ($validated as $key => $value) {
                if ($value === null) {
                    $missingParams[] = $key;
                }
            }

            if (!empty($missingParams)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Missing parameters: ' . implode(', ', $missingParams),
                ], 200);
            }

            // Update only the fields that are provided
            $serviceRequest->update($validated);

            return response()->json([
                'status' => true,
                'message' => 'Service request updated successfully.',
                'data' => $serviceRequest,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to update service request',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
