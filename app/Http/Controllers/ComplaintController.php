<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class ComplaintController extends Controller
{
    // Retrieve complaints either for a specific user or all complaints
    public function index(Request $request)
    {
        // Get 'user_id' from the input body, defaulting to 'all' if not provided
        $userId = $request->input('user_id', 'all');

        if ($userId !== 'all') {
            // Retrieve complaints for a specific user
            $complaints = Complaint::where('user_id', $userId)->get();
        } else {
            // Retrieve all complaints
            $complaints = Complaint::all();
        }

        // Format the response to match the desired structure
        return response()->json([
            'status' => true,
            'message' => 'Complaints retrieved successfully.',
            'data' => $complaints->map(function ($complaint) {
                return [
                    'no' => $complaint->id,
                    'blockNumber' => $complaint->block_number,
                    'image' => $complaint->image,
                    'visitorName' => $complaint->complaint_by,
                    'date' => $complaint->date,
                    'complainDescription' => $complaint->complaint_desc,
                    'complainTitle' => $complaint->complaint_title,
                    'status' => $complaint->complaint_status,
                    'photos' => json_decode($complaint->photos), // Assuming it's stored as JSON in DB
                ];
            }),
        ]);
    }

    // Retrieve a specific complaint by ID
    public function show(Request $request)
    {
        // Get 'id' from the input body
        $complaintId = $request->input('id');

        $complaint = Complaint::find($complaintId);

        if (!$complaint) {
            return response()->json(['status' => false, 'message' => 'Complaint not found.', 'data' => null], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Complaint retrieved successfully.',
            'data' => [
                'no' => $complaint->id,
                'blockNumber' => $complaint->block_number,
                'image' => $complaint->image,
                'visitorName' => $complaint->complaint_by,
                'date' => $complaint->date,
                'complainDescription' => $complaint->complaint_desc,
                'complainTitle' => $complaint->complaint_title,
                'status' => $complaint->complaint_status,
                'photos' => json_decode($complaint->photos),
            ]
        ]);
    }

    // Store a new complaint
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'user_id' => 'required',
                'complaint_title' => 'required|string|max:255',
                'complaint_desc' => 'required|string',
                'date' => 'required|date',
                'photos' => 'required|string',
                'complaint_status' => 'required|in:pending,active,deactive',
                'status' => 'nullable|in:active,deactive',
            ]);
        } catch (ValidationException $e) {
            // Return a detailed response for missing fields
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'missing_fields' => array_keys($e->errors())
            ], 400);
        }

        $user = User::findOrFail($request->user_id);
        $complaint = new Complaint([
            'block_number' => $user->block_number,
            'complaint_by' => $user->first_name . ' ' . $user->last_name,
            'complaint_title' => $validatedData['complaint_title'],
            'user_id' => $user->id,
            'complaint_desc' => $validatedData['complaint_desc'],
            'date' => $validatedData['date'],
            'complaint_status' => $validatedData['complaint_status'],
            'photos' => $validatedData['photos'],
            'status' => $validatedData['status'] ?? 'active',
        ]);

        $complaint->save();

        return response()->json([
            'status' => true,
            'message' => 'Complaint created successfully.',
            'data' => $complaint
        ], 201);
    }

    // Update an existing complaint
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|integer|exists:complaints,id',
            'complaint_title' => 'required|string|max:255',
            'complaint_desc' => 'required|string',
            'date' => 'required|date',
            'photos' => 'nullable|string',
            'complaint_status' => 'required|in:pending,active,deactive',
            'status' => 'nullable|in:active,deactive',
        ]);

        // Find the complaint by ID
        $complaint = Complaint::find($validatedData['id']);
        if (!$complaint) {
            return response()->json(['status' => false, 'message' => 'Complaint not found.'], 404);
        }

        // Update the complaint fields
        $complaint->update([
            'complaint_title' => $validatedData['complaint_title'],
            'complaint_desc' => $validatedData['complaint_desc'],
            'date' => $validatedData['date'],
            'photos' => $validatedData['photos'] ?? $complaint->photos,
            'complaint_status' => $validatedData['complaint_status'],
            'status' => $validatedData['status'] ?? $complaint->status,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Complaint updated successfully.',
            'data' => $complaint
        ]);
    }

    // Delete an existing complaint
    public function destroy(Request $request)
    {
        $complaintId = $request->input('id');

        $complaint = Complaint::find($complaintId);
        if (!$complaint) {
            return response()->json(['status' => false, 'message' => 'Complaint not found.'], 404);
        }

        $complaint->delete();

        return response()->json([
            'status' => true,
            'message' => 'Complaint deleted successfully.',
            'data' => null
        ]);
    }
}
