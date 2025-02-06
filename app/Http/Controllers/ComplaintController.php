<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ComplaintController extends Controller
{
    // Retrieve complaints either for a specific user or all complaints
    // public function index(Request $request)
    // {
    //     // Get 'user_id' from the input body, defaulting to 'all' if not provided
    //     $userId = $request->input('user_id', 'all');

    //     if ($userId !== 'all') {
    //         // Retrieve complaints for a specific user
    //         $complaints = Complaint::where('user_id', $userId)->get();
    //     } else {
    //         // Retrieve all complaints
    //         $complaints = Complaint::all();
    //     }

    //     // Format the response to match the desired structure
    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Complaints retrieved successfully.',
    //         'data' => $complaints->map(function ($complaint) {
    //             return [
    //                 'no' => $complaint->id,
    //                 'blockNumber' => $complaint->block_number,
    //                 'image' => asset('storage/' . $complaint->image), // Generate URL for the single image
    //                 'complainant' => $complaint->complaint_by,
    //                 'date' =>  \Carbon\Carbon::parse($complaint->date)->format('d-m-Y'),
    //                 'complainDescription' => $complaint->complaint_desc,
    //                 'complainTitle' => $complaint->complaint_title,
    //                 'status' => $complaint->complaint_status,
    //                 'photos' => array_map(function ($photo) {
    //                     return asset('storage/' . $photo); // Generate URL for each photo in the array
    //                 }, json_decode($complaint->photos)),  // Assuming photos are stored as JSON
    //             ];
    //         }),
    //     ]);
    // }

    public function index(Request $request)
    {
        // Get the logged-in user's society_id
        $loggedInUser = auth()->user();
        $loggedInSocietyId = $loggedInUser->society_id;

        // Get all user IDs that belong to the same society_id as the logged-in user
        $userIdsInSameSociety = \App\Models\User::where('society_id', $loggedInSocietyId)->pluck('id');

        // Check 'user_id' input from the body, defaulting to 'all'
        $userId = $request->input('user_id', 'all');

        // Query the complaints table
        $query = Complaint::whereIn('user_id', $userIdsInSameSociety);

        if ($userId !== 'all') {
            // Filter complaints for the specific user_id
            $query->where('user_id', $userId);
        }

        // Retrieve the complaints
        $complaints = $query->get();

        // Format the response
        return response()->json([
            'status' => true,
            'message' => 'Complaints retrieved successfully.',
            'data' => $complaints->map(function ($complaint, $index) {
                return [
                    'no' => $index + 1, // Set 'no' as $index + 1
                    'id' => $complaint->id, // Set 'id' as the complaint id
                    'user_id' => $complaint->user_id,
                    'blockNumber' => $complaint->block_number,
                    'image' => asset('storage/' . $complaint->image), // Generate URL for the single image
                    'complainant' => $complaint->complaint_by,
                    'date' => \Carbon\Carbon::parse($complaint->date)->format('d-m-Y'),
                    'complainDescription' => $complaint->complaint_desc,
                    'complainTitle' => $complaint->complaint_title,
                    'reason' => $complaint->reason,
                    'status' => $complaint->complaint_status,
                    'photos' => array_map(function ($photo) {
                        return asset('storage/' . $photo); // Generate URL for each photo in the array
                    }, json_decode($complaint->photos)), // Assuming photos are stored as JSON
                ];
            }),
        ]);
    }

    // // Retrieve a specific complaint by ID
    // public function show(Request $request)
    // {
    //     // Get 'id' from the input body
    //     $complaintId = $request->input('id');

    //     $complaint = Complaint::find($complaintId);

    //     if (!$complaint) {
    //         return response()->json(['status' => false, 'message' => 'Complaint not found.', 'data' => null], 404);
    //     }

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Complaint retrieved successfully.',
    //         'data' => [
    //             'no' => $complaint->id,
    //             'blockNumber' => $complaint->block_number,
    //             'image' => asset('storage/' . $complaint->image),  // Generate URL for the image
    //             'complainant' => $complaint->complaint_by,
    //             'date' =>  \Carbon\Carbon::parse($complaint->date)->format('d-m-Y'),
    //             'complainDescription' => $complaint->complaint_desc,
    //             'complainTitle' => $complaint->complaint_title,
    //             'status' => $complaint->complaint_status,
    //             'photos' => array_map(function ($photo) {
    //                 return asset('storage/' . $photo); // Generate URL for each photo in the array
    //             }, json_decode($complaint->photos)),  // Assuming photos are stored as JSON
    //         ]
    //     ]);
    // }

    // Retrieve a specific complaint by ID
    public function show(Request $request)
    {
        // Get 'id' from the input body
        $complaintId = $request->input('id');

        // Get the logged-in user's society_id
        $loggedInUser = auth()->user();
        $loggedInSocietyId = $loggedInUser->society_id;

        // Retrieve the complaint
        $complaint = Complaint::find($complaintId);

        if (!$complaint) {
            return response()->json(['status' => false, 'message' => 'Complaint not found.', 'data' => null], 404);
        }

        // Verify if the complaint belongs to the same society as the logged-in user
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
                'image' => asset('storage/' . $complaint->image), // Generate URL for the image
                'complainant' => $complaint->complaint_by,
                'date' => \Carbon\Carbon::parse($complaint->date)->format('d-m-Y'),
                'complainDescription' => $complaint->complaint_desc,
                'complainTitle' => $complaint->complaint_title,
                'reason' => $complaint->reason,
                'status' => $complaint->complaint_status,
                'photos' => array_map(function ($photo) {
                    return asset('storage/' . $photo); // Generate URL for each photo in the array
                }, json_decode($complaint->photos)), // Assuming photos are stored as JSON
            ],
        ]);
    }


    // Store a new complaint
    // public function store(Request $request)
    // {
    //     try {
    //         $validatedData = $request->validate([
    //             'user_id' => 'required',
    //             'complaint_title' => 'required|string|max:255',
    //             'complaint_desc' => 'required|string',
    //             'date' => 'required|date',
    //             'photos' => 'required|string',
    //             'complaint_status' => 'required|in:pending,active,deactive',
    //             'status' => 'nullable|in:active,deactive',
    //         ]);
    //     } catch (ValidationException $e) {
    //         // Return a detailed response for missing fields
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Validation failed',
    //             'missing_fields' => array_keys($e->errors())
    //         ], 400);
    //     }

    //     $user = User::findOrFail($request->user_id);
    //     $complaint = new Complaint([
    //         'block_number' => $user->block_number,
    //         'complaint_by' => $user->first_name . ' ' . $user->last_name,
    //         'complaint_title' => $validatedData['complaint_title'],
    //         'user_id' => $user->id,
    //         'complaint_desc' => $validatedData['complaint_desc'],
    //         'date' => $validatedData['date'],
    //         'complaint_status' => $validatedData['complaint_status'],
    //         'photos' => $validatedData['photos'],

    //         'status' => $validatedData['status'] ?? 'active',
    //     ]);

    //     $complaint->save();

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Complaint created successfully.',
    //         'data' => $complaint
    //     ], 201);
    // }

    // Store a new complaint
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'user_id' => 'required|exists:users,id',
                'complaint_title' => 'required|string|max:255',
                'complaint_desc' => 'required|string',
                'date' => 'required|date',
                'image' => 'nullable|image',
                'photos' => 'nullable', // Allow multiple files
                'photos.*' => 'image', // Validate each file
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

        // Fetch the user
        $user = User::findOrFail($request->user_id);

        // Allow only owner (role_id = 3) and tenant (role_id = 4)
        if (!in_array($user->role_id, [3, 4])) {
            return response()->json([
                'status' => false,
                'message' => 'Only owners and tenants can create complaints.',
            ], 403);
        }

        // // Handle photo uploads
        // $photoPaths = [];
        // if ($request->hasFile('photos')) {
        //     foreach ($request->file('photos') as $photo) {
        //         $photoPath = $photo->store('complaint_images', 'public');
        //         $photoPaths[] = $photoPath;
        //     }
        // }

        $imageUrl = $this->storeFileInPublicFolder($request->file('image'), 'complaint_images');

        $documentPaths = [];
        if ($request->hasFile('photos')) {
            // If it's multiple files
            if (is_array($request->file('photos'))) {
                foreach ($request->file('photos') as $document) {
                    // Store each document and get the path
                    $documentPath = $this->storeFileInPublicFolder($document, 'complaint_images');
                    $documentPaths[] = $documentPath;
                }
            } else {
                // If it's a single file
                $documentPath = $this->storeFileInPublicFolder($request->file('photos'), 'complaint_images');
                $documentPaths[] = $documentPath;
            }
        }


        // Create the complaint
        $complaint = Complaint::create([
            'block_number' => $user->block_number,
            'complaint_by' => $user->first_name . ' ' . $user->last_name,
            'complaint_title' => $validatedData['complaint_title'],
            'user_id' => $user->id,
            'complaint_desc' => $validatedData['complaint_desc'],
            'date' => $validatedData['date'],
            'image' => $imageUrl,
            'complaint_status' => $validatedData['complaint_status'] ??  "pending",
            'photos' => json_encode($documentPaths), // Store as JSON array
            'status' => $validatedData['status'] ?? 'active',
            'reason' => $validatedData['reason'] ?? null,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Complaint created successfully.',
            'data' => $complaint
        ], 201);
    }


    // Update an existing complaint
    // public function update(Request $request)
    // {
    //     $validatedData = $request->validate([
    //         'id' => 'required|integer|exists:complaints,id',
    //         'complaint_title' => 'required|string|max:255',
    //         'complaint_desc' => 'required|string',
    //         'date' => 'required|date',
    //         'photos' => 'nullable|string',
    //         'complaint_status' => 'required|in:pending,active,deactive',
    //         'status' => 'nullable|in:active,deactive',
    //         'reason' => 'nullable'
    //     ]);

    //     // Find the complaint by ID
    //     $complaint = Complaint::find($validatedData['id']);
    //     if (!$complaint) {
    //         return response()->json(['status' => false, 'message' => 'Complaint not found.'], 404);
    //     }

    //     // Update the complaint fields
    //     $complaint->update([
    //         'complaint_title' => $validatedData['complaint_title'],
    //         'complaint_desc' => $validatedData['complaint_desc'],
    //         'date' => $validatedData['date'],
    //         'photos' => $validatedData['photos'] ?? $complaint->photos,
    //         'complaint_status' => $validatedData['complaint_status'],
    //         'status' => $validatedData['status'] ?? $complaint->status,
    //         'reason' => $validatedData['reason'] ?? $complaint->reason,
    //     ]);

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Complaint updated successfully.',
    //         'data' => $complaint
    //     ]);
    // }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|integer|exists:complaints,id',
            'complaint_title' => 'nullable|string|max:255',
            'complaint_desc' => 'nullable|string',
            'date' => 'nullable|date',
            'image' => 'nullable|image',
            'photos' => 'nullable', // Allow multiple files
            'photos.*' => 'image', // Validate each file
            'complaint_status' => 'sometimes|in:pending,approved,rejected',
            'status' => 'sometimes|in:active,deactive',
            'reason' => 'nullable|string'
        ]);
        // dd($request);

        // Find the complaint
        $complaint = Complaint::findOrFail($validatedData['id']);
        // dd(\Carbon\Carbon::parse($complaint->date)->format('Y-m-d'));
        // Fetch the user
        $user = User::findOrFail($complaint->user_id);

        // Allow only owners (role_id = 3) and tenants (role_id = 4) to update complaints
        if (!in_array($user->role_id, [1, 2, 3, 4])) {
            return response()->json([
                'status' => false,
                'message' => 'Only owners and tenants can update complaints.',
            ], 403);
        }

        // Handle new image upload
        $imageUrl = $complaint->image; // Keep the existing image by default
        if ($request->hasFile('image')) {
            $imageUrl = $this->storeFileInPublicFolder($request->file('image'), 'complaint_images');
        }

        // Handle photo uploads (single or multiple)
        $documentPaths = json_decode($complaint->photos, true) ?? []; // Keep existing photos
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
                    // 'data' => $booking
                ]);
            } else {
                $complaint->reason = $request->reason;
                $complaint->complaint_status = $request->complaint_status;
            }
        } else {
            $complaint->complaint_status = $request->complaint_status;
        }

        // Update the complaint fields
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

    protected function storeFileInPublicFolder($file, $folder)
    {
        // Generate a unique file name
        $filename = time() . '_' . $file->getClientOriginalName();
        $filename = str_replace(' ', '_', $filename);
        // Move the file to the desired folder in public/storage
        $file->move(public_path("storage/{$folder}"), $filename);

        // Return the relative path to the file
        return "{$folder}/{$filename}";
    }
}
