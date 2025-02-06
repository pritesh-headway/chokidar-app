<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GateDetail;

class GateDetailController extends Controller
{

    public function store(Request $request)
    {
        $validated = $request->validate([
            'gate_no' => 'required|integer|unique:gate_details',
            'security_id' => 'required|exists:securities,id',
            'gate_mobile' => 'required|string|size:10',
            'status' => 'required|in:active,deactive',
        ]);

        $gateDetail = GateDetail::create($validated);

        return response()->json([
            'status' => true,
            'message' => 'Gate detail retrieved successfully',
            'data' => $gateDetail
        ]);
    }
    public function index(Request $request)
    {
        $gateDetails = GateDetail::where('status', 'active')->get();
        return response()->json([
            'status' => true,
            'message' => 'Gate detail retrieved successfully',
            'data' => $gateDetails
        ]);
    }

    public function show(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|integer|exists:gate_details,id',
        ]);

        $gateDetail = GateDetail::where('status', 'active')
            ->findOrFail($request->id);

        return response()->json([
            'status' => true,
            'message' => 'Gate detail retrieved successfully',
            'data' => $gateDetail
        ]);
    }

    public function getByGateNo(Request $request)
    {
        $validated = $request->validate([
            'gate_no' => 'required|integer',
        ]);

        $societyId = auth()->user()->society_id;

        $gateDetails = GateDetail::where('gate_no', $validated['gate_no'])
            ->where('society_id', $societyId)
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Gate detail retrieved successfully',
            'data' => $gateDetails
        ]);
    }
    public function update(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|integer|exists:gate_details,id',
            'gate_no' => 'sometimes|required|integer',
            'security_id' => 'sometimes|required|exists:securities,id',
            'gate_mobile' => 'sometimes|required|string|size:10',
            'status' => 'sometimes|required|in:active,deactive',
        ]);

        $gateDetail = GateDetail::findOrFail($request->id);
        $gateDetail->update($validated);

        return response()->json([
            'status' => true,
            'message' => 'Gate detail retrieved successfully',
            'data' => $gateDetail
        ]);
    }
    public function destroy(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|integer|exists:gate_details,id',
        ]);

        $gateDetail = GateDetail::findOrFail($request->id);
        $gateDetail->delete();

        return response()->json([
            'status' => true,
            'message' => 'Gate detail deleted successfully'
        ]);
    }
}
