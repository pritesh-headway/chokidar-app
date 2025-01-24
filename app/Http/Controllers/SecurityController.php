<?php

namespace App\Http\Controllers;

use App\Models\Security;
use App\Models\GateDetail;
use Illuminate\Http\Request;

class SecurityController extends Controller
{
    // Display a listing of the securities (by user_id if provided)
    // public function index(Request $request)
    // {
    //     $securities = Security::all();

    //     // Add full URLs for images and documents
    //     $securitiesWithUrls = $securities->map(function ($security) {
    //         return [
    //             'id' => $security->id,
    //             'guard_name' => $security->guard_name,
    //             'mobile' => $security->mobile,
    //             'address' => $security->address,
    //             'gate_no' => $security->gate_no,
    //             'details' => $security->details,
    //             'guard_image' => env('APP_URL') . '/public/storage/' . $security->guard_image,
    //             'documents' => env('APP_URL') . '/public/storage/' . $security->documents,
    //             'status' => $security->status,
    //         ];
    //     });

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Securities retrieved successfully.',
    //         'data' => $securitiesWithUrls,
    //     ]);
    // }
    // Store a new security record
    public function store(Request $request)
    {
        // Validate the request
        $validatedData = $request->validate([
            'guard_name' => 'required|string|max:50',
            'mobile' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'gate_no' => 'required|integer',
            'details' => 'required|string',
            'guard_image' => 'required|string|max:256',
            'documents' => 'required|array',
            'status' => 'nullable|in:active,deactive',
        ]);

        // Default to 'deactive' status if not provided
        $status = $request->get('status', 'deactive');

        // Create the security record
        $security = Security::create([
            'guard_name' => $request->guard_name,
            'mobile' => $request->mobile,
            'address' => $request->address,
            'gate_no' => $request->gate_no,
            'details' => $request->details,
            'guard_image' => $request->guard_image,
            'documents' => json_encode($request->documents),
            'status' => $status,
        ]);

        return response()->json(['message' => 'Security record created successfully.', 'data' => $security], 201);
    }

    // // Show a specific security record
    // public function show(Request $request)
    // {
    //     $validatedData = $request->validate([
    //         'id' => 'required|integer|exists:securities,id',
    //     ]);

    //     // Retrieve the security record by id
    //     $security = Security::findOrFail($request->id);

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Security retrieved successfully.',
    //         'data' => [
    //             'id' => $security->id,
    //             'guard_name' => $security->guard_name,
    //             'mobile' => $security->mobile,
    //             'address' => $security->address,
    //             'gate_no' => $security->gate_no,
    //             'details' => $security->details,
    //             'guard_image' => $security->guard_image,
    //             'documents' => $security->documents,
    //             'status' => $security->status,
    //         ],
    //     ]);
    // }

    // Update a specific security record
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|integer|exists:securities,id',
            'guard_name' => 'nullable|string|max:50',
            'mobile' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'gate_no' => 'nullable|integer',
            'details' => 'nullable|string',
            'guard_image' => 'nullable|string|max:256',
            'documents' => 'nullable|array',
            'status' => 'nullable|in:active,deactive',
        ]);

        $security = Security::findOrFail($request->id);
        $security->update($validatedData);

        return response()->json(['message' => 'Security updated successfully.', 'data' => $security]);
    }

    // Destroy a specific security record
    public function destroy(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|integer|exists:securities,id',
        ]);

        $security = Security::findOrFail($request->id);
        $security->delete();

        return response()->json(['message' => 'Security deleted successfully.']);
    }
    // Display all securities with associated gate details
    public function index(Request $request)
    {
        $securities = Security::whereHas('gateDetails')->get(); // Filter only securities with gate details

        $securitiesWithDetails = $securities->map(function ($security, $index) {
            $gateDetails = $security->gateDetails->first(); // Get the first associated gate detail
            return [
                'id' => $security->id,
                'no' => $index + 1,
                'guard_name' => $security->guard_name,
                'personal_mobile' => $security->mobile,
                'address' => $security->address,
                'gate_no' => $gateDetails->gate_no ?? null, // Get gate number from gate details
                'gate_mobile' => $gateDetails->gate_mobile ?? null, // Get gate mobile from gate details
                'details' => $security->details,
                'guard_image' => $this->getFullUrl($security->guard_image),
                'documents' => $this->getFullUrls($security->documents),
                'status' => $security->status,
            ];
        });

        return response()->json([
            'status' => true,
            'message' => 'Securities retrieved successfully.',
            'data' => $securitiesWithDetails,
        ]);
    }

    // Show a specific security record by id with gate details
    public function show(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|integer|exists:securities,id',
        ]);

        $security = Security::with('gateDetails')->findOrFail($request->id);

        $gateDetails = $security->gateDetails->first(); // Get the first associated gate detail

        return response()->json([
            'status' => true,
            'message' => 'Security retrieved successfully.',
            'data' => [
                'id' => $security->id,
                'no' => 1,
                'guard_name' => $security->guard_name,
                'personal_mobile' => $security->mobile,
                'address' => $security->address,
                'gate_no' => $gateDetails->gate_no ?? null,
                'gate_mobile' => $gateDetails->gate_mobile ?? null,
                'details' => $security->details,
                'guard_image' => $this->getFullUrl($security->guard_image),
                'documents' => $this->getFullUrls($security->documents),
                'status' => $security->status,
            ],
        ]);
    }

    // Helper function to get full URLs for multiple documents
    protected function getFullUrls($documents)
    {
        // Decode the JSON string into an array
        $documentsArray = json_decode($documents, true);

        // Check if decoding was successful and is an array
        if (is_array($documentsArray)) {
            return collect($documentsArray)->map(function ($doc) {
                return $this->getFullUrl($doc);
                // return  env('APP_URL') . '/public/storage/' . $doc;
            })->toArray();
        }

        // Return an empty array if decoding fails or it's not an array
        return [];
    }

    // Helper function to get the full URL of a single image or document
    protected function getFullUrl($path)
    {
        // dd(env('APP_URL'));
        return config('app.url') . '/public/storage/' . $path;
    }
}
