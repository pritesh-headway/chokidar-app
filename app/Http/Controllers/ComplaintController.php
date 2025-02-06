<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ComplaintController extends Controller
{
    public function index(Request $request)
    {

        $loggedInUser = auth()->user();
        $loggedInSocietyId = $loggedInUser->society_id;
        $userIdsInSameSociety = \App\Models\User::where('society_id', $loggedInSocietyId)->pluck('id');
        $userId = $request->input('user_id', 'all');
        $query = Complaint::whereIn('user_id', $userIdsInSameSociety);

        if ($userId !== 'all') {

            $query->where('user_id', $userId);
        }
        $complaints = $query->get();
        return response()->json([
            'status' => true,
            'message' => 'Complaints retrieved successfully.',
            'data' => $complaints->map(function ($complaint, $index) {
                return [
                    'no' => $index + 1,
                    'id' => $complaint->id,
                    'user_id' => $complaint->user_id,
                    'blockNumber' => $complaint->block_number,
                    'image' => asset('storage/' . $complaint->image),
                    'complainant' => $complaint->complaint_by,
                    'date' => \Carbon\Carbon::parse($complaint->date)->format('d-m-Y'),
                    'complainDescription' => $complaint->complaint_desc,
                    'complainTitle' => $complaint->complaint_title,
                    'reason' => $complaint->reason,
                    'status' => $complaint->complaint_status,
                    'photos' => array_map(function ($photo) {
                        return asset('storage/' . $photo);
                    }, json_decode($complaint->photos)),
                ];
            }),
        ]);
    }
    public function show(Request $request)
    {

        $complaintId = $request->input('id');
        $loggedInUser = auth()->user();
        $loggedInSocietyId = $loggedInUser->society_id;
        $complaint = Complaint::find($complaintId);

        if (!$complaint) {
            return response()->json(['status' => false, 'message' => 'Complaint not found.', 'data' => null], 404);
        }
        $complainant = \App\Models\User::find($complaint->user_id);

        if (!$complainant || $complainant->society_id !== $loggedInSocietyId) {
            return response()->json(['status' => false, 'message' => 'Unauthorized access to this complaint.', 'data' => null], 403);
        }

        return response()->json([
            'status' => true,
            'message' => 'Complaint retrieved successfully.',
            'data' => [
                'no' => $complaint->id,
                'user_id' => $complaint->user_id,
                'blockNumber' => $complaint->block_number,
                'image' => asset('storage/' . $complaint->image),
                'complainant' => $complaint->complaint_by,
                'date' => \Carbon\Carbon::parse($complaint->date)->format('d-m-Y'),
                'complainDescription' => $complaint->complaint_desc,
                'complainTitle' => $complaint->complaint_title,
                'reason' => $complaint->reason,
                'status' => $complaint->complaint_status,
                'photos' => array_map(function ($photo) {
                    return asset('storage/' . $photo);
                }, json_decode($complaint->photos)),
            ],
        ]);
    }
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'user_id' => 'required|exists:users,id',
                'complaint_title' => 'required|string|max:255',
                'complaint_desc' => 'required|string',
                'date' => 'required|date',
                'image' => 'nullable|image',
                'photos' => 'nullable',
                'photos.*' => 'image',
                'complaint_status' => 'nullable|in:pending,active,deactive',
                'status' => 'nullable|in:active,deactive',
                'reason' => 'nullable|string',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'missing_fields' => array_keys($e->errors()),
            ], 400);
        }
        $user = User::findOrFail($request->user_id);
        if (!in_array($user->role_id, [3, 4])) {
            return response()->json([
                'status' => false,
                'message' => 'Only owners and tenants can create complaints.',
            ], 403);
        }
        $imageUrl = $this->storeFileInPublicFolder($request->file('image'), 'complaint_images');

        $documentPaths = [];
        if ($request->hasFile('photos')) {

            if (is_array($request->file('photos'))) {
                foreach ($request->file('photos') as $document) {

                    $documentPath = $this->storeFileInPublicFolder($document, 'complaint_images');
                    $documentPaths[] = $documentPath;
                }
            } else {

                $documentPath = $this->storeFileInPublicFolder($request->file('photos'), 'complaint_images');
                $documentPaths[] = $documentPath;
            }
        }
        $complaint = Complaint::create([
            'block_number' => $user->block_number,
            'complaint_by' => $user->first_name . ' ' . $user->last_name,
            'complaint_title' => $validatedData['complaint_title'],
            'user_id' => $user->id,
            'complaint_desc' => $validatedData['complaint_desc'],
            'date' => $validatedData['date'],
            'image' => $imageUrl,
            'complaint_status' => $validatedData['complaint_status'] ??  "pending",
            'photos' => json_encode($documentPaths),
            'status' => $validatedData['status'] ?? 'active',
            'reason' => $validatedData['reason'] ?? null,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Complaint created successfully.',
            'data' => $complaint
        ], 201);
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|integer|exists:complaints,id',
            'complaint_title' => 'nullable|string|max:255',
            'complaint_desc' => 'nullable|string',
            'date' => 'nullable|date',
            'image' => 'nullable|image',
            'photos' => 'nullable',
            'photos.*' => 'image',
            'complaint_status' => 'sometimes|in:pending,approved,rejected',
            'status' => 'sometimes|in:active,deactive',
            'reason' => 'nullable|string'
        ]);
        $complaint = Complaint::findOrFail($validatedData['id']);
        $user = User::findOrFail($complaint->user_id);
        if (!in_array($user->role_id, [1, 2, 3, 4])) {
            return response()->json([
                'status' => false,
                'message' => 'Only owners and tenants can update complaints.',
            ], 403);
        }
        $imageUrl = $complaint->image;
        if ($request->hasFile('image')) {
            $imageUrl = $this->storeFileInPublicFolder($request->file('image'), 'complaint_images');
        }
        $documentPaths = json_decode($complaint->photos, true) ?? [];
        if ($request->hasFile('photos')) {
            if (is_array($request->file('photos'))) {
                foreach ($request->file('photos') as $photo) {
                    $documentPaths[] = $this->storeFileInPublicFolder($photo, 'complaint_images');
                }
            } else {
                $documentPaths[] = $this->storeFileInPublicFolder($request->file('photos'), 'complaint_images');
            }
        }
        if ($request->complaint_status == 'rejected') {
            if ($request->reason == null) {
                return response()->json([
                    'status' => false,
                    'message' => 'Reason is required for rejecting.',

                ]);
            } else {
                $complaint->reason = $request->reason;
                $complaint->complaint_status = $request->complaint_status;
            }
        } else {
            $complaint->complaint_status = $request->complaint_status;
        }
        $complaint->update([
            'complaint_title' => $validatedData['complaint_title'] ?? $complaint->complaint_title,
            'complaint_desc' => $validatedData['complaint_desc'] ?? $complaint->complaint_desc,
            'date' => $validatedData['date'] ?? Carbon::parse($complaint->date)->format('Y-m-d'),
            'image' => $imageUrl ?? $complaint->image,
            'photos' => json_encode($documentPaths) ?? $complaint->photos,
            'complaint_status' => $validatedData['complaint_status'] ?? $complaint->complaint_status,
            'status' => $validatedData['status'] ?? $complaint->status,
            'reason' => $validatedData['reason'] ?? $complaint->reason,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Complaint updated successfully.',
            'data' => $complaint
        ]);
    }
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

    protected function storeFileInPublicFolder($file, $folder)
    {

        $filename = time() . '_' . $file->getClientOriginalName();
        $filename = str_replace(' ', '_', $filename);

        $file->move(public_path("storage/{$folder}"), $filename);
        return "{$folder}/{$filename}";
    }
}
