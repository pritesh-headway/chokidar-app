<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GateDetail;

class GateDetailController extends Controller
{
    // Store a newly created gate detail
    public function store(Request $request)
    {
        $validated = $request->validate([
            'gate_no' => 'required|integer|unique:gate_details',
            'security_id' => 'required|exists:securities,id',
            'gate_mobile' => 'required|string|size:10',  // Ensure mobile number is 10 digits
            'status' => 'required|in:active,deactive',
        ]);

        $gateDetail = GateDetail::create($validated);

        return response()->json($gateDetail, 201);
    }

    // Fetch all gate details (POST request)
    public function index(Request $request)
    {
        $gateDetails = GateDetail::all();
        return response()->json($gateDetails);
    }

    // Fetch a specific gate detail (POST request with ID in body)
    public function show(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|integer|exists:gate_details,id', // Validate ID
        ]);

        $gateDetail = GateDetail::findOrFail($request->id);
        return response()->json($gateDetail);
    }
    // Fetch gate details by gate_no and society_id
    public function getByGateNo(Request $request)
    {
        $validated = $request->validate([
            'gate_no' => 'required|integer',
        ]);

        $societyId = auth()->user()->society_id;

        $gateDetails = GateDetail::where('gate_no', $validated['gate_no'])
            ->where('society_id', $societyId)
            ->get();

        return response()->json($gateDetails);
    }

    // Update a specific gate detail (POST request with ID in body)
    public function update(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|integer|exists:gate_details,id', // Validate ID
            'gate_no' => 'sometimes|required|integer',
            'security_id' => 'sometimes|required|exists:securities,id',
            'gate_mobile' => 'sometimes|required|string|size:10',
            'status' => 'sometimes|required|in:active,deactive',
        ]);

        $gateDetail = GateDetail::findOrFail($request->id);
        $gateDetail->update($validated);

        return response()->json($gateDetail);
    }

    // Delete a specific gate detail (POST request with ID in body)
    public function destroy(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|integer|exists:gate_details,id', // Validate ID
        ]);

        $gateDetail = GateDetail::findOrFail($request->id);
        $gateDetail->delete();

        return response()->json(['message' => 'Gate detail deleted successfully.']);
    }
}
