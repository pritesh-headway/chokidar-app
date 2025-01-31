<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoticeController extends Controller
{
    // Store a newly created notice (with documents)
    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'notice_title' => 'required|string|max:255',
    //         'notice_desc' => 'required|string',
    //         'date' => 'required|date',
    //         'time' => 'required|date_format:H:i:s',
    //         'status' => 'required|in:active,deactive',
    //         'documents' => 'nullable|array',  // documents should be an array of URLs
    //     ]);

    //     // Generate the document URLs (if documents are provided)
    //     if ($request->has('documents') && is_array($request->documents)) {
    //         $documentUrls = array_map(function ($document) {
    //             return env('APP_URL') . '/storage/notice_documents/' . $document; // Construct the full URL
    //         }, $request->documents);
    //     } else {
    //         $documentUrls = [];
    //     }

    //     // Create the notice with the documents URLs
    //     $notice = Notice::create([
    //         'notice_title' => $request->notice_title,
    //         'notice_desc' => $request->notice_desc,
    //         'date' => $request->date,
    //         'time' => $request->time,
    //         'status' => $request->status,
    //         'documents' => json_encode($documentUrls), // Store the URLs as a JSON array
    //     ]);

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Notice created successfully.',
    //         'data' => $notice
    //     ], 201);
    // }

    public function store(Request $request)
    {
        // Ensure the user has role_id 1 or 2 to create a notice
        $user = auth()->user();
        if (!in_array($user->role_id, [1, 2])) {
            return response()->json([
                'status' => false,
                'message' => 'You do not have permission to create notices.',
            ], 403);
        }

        // Validate required fields
        $validated = $request->validate([
            'notice_title' => 'required|string|max:255',
            'notice_desc' => 'required|string',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i:s',
            'documents' => 'nullable',  // documents should be an array of file uploads
        ]);

        // Handle document and photo uploads
        $documentPaths = [];
        if ($request->hasFile('documents')) {
            // If it's multiple files
            if (is_array($request->file('documents'))) {
                foreach ($request->file('documents') as $document) {
                    // Store each document and get the path
                    $documentPath = $this->storeFileInPublicFolder($document, 'documents');
                    $documentPaths[] = $documentPath;
                }
            } else {
                // If it's a single file
                $documentPath = $this->storeFileInPublicFolder($request->file('documents'), 'notice_documents');
                $documentPaths[] = $documentPath;
            }
        }
        // dd($documentPaths);
        // dd($user->society_id);
        // Create the notice with provided data
        $notice = Notice::create([
            'notice_title' => $request->notice_title,
            'notice_desc' => $request->notice_desc,
            'date' => $request->date,
            'time' => $request->time,
            'status' => 'active',  // Default status set to active
            'documents' => json_encode($documentPaths), // Store document URLs as JSON array
            'society_id' => $user->society_id, // Take society_id from authenticated user's society_id
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Notice created successfully.',
            'data' => $notice
        ], 201);
    }


    // Fetch all notices (accepting POST request)
    // public function index(Request $request)
    // {
    //     // $user = Auth::user();
    //     // dd($user->hello());

    //     // Retrieve all notices
    //     $notices = Notice::all();

    //     // Map the notices to include a consistent "no" index
    //     $noticesWithNo = $notices->map(function ($notice, $index) {
    //         return [
    //             'no' => $index + 1,  // Provide a consistent index number starting from 1
    //             'id' => $notice->id,
    //             'notice_title' => $notice->notice_title,
    //             'notice_desc' => $notice->notice_desc,
    //             'date' => \Carbon\Carbon::parse($notice->date)->format('d-m-Y'),
    //             'time' => $notice->time,
    //             'status' => $notice->status,
    //             'documents' => json_decode($notice->documents), // Convert documents URL array back to array
    //         ];
    //     });

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Notices retrieved successfully.',
    //         'data' => $noticesWithNo
    //     ]);
    // }

    public function index(Request $request)
    {
        // Get the logged-in user's society_id
        $loggedInUser = auth()->user();
        $loggedInSocietyId = $loggedInUser->society_id;

        // Retrieve notices where society_id matches the logged-in user's society_id
        $notices = Notice::where('society_id', $loggedInSocietyId)
            ->orderBy('date', 'desc') // Order by date (most recent first)
            ->paginate(10); // 10 notices per page

        // Map the notices to include a consistent "no" index
        $noticesWithNo = $notices->map(function ($notice, $index) {
            return [
                'no' => $index + 1,  // Provide a consistent index number starting from 1
                'id' => $notice->id,
                'notice_title' => $notice->notice_title,
                'notice_desc' => $notice->notice_desc,
                'date' => \Carbon\Carbon::parse($notice->date)->format('d-m-Y'),
                'time' => $notice->time,
                'status' => $notice->status,
                'documents' => $notice->documents ? array_map(function ($document) {
                    return asset('storage/' . $document); // Generate URL for each document in the array
                }, json_decode($notice->documents)) : [], // If documents is null, return an empty array
            ];
        });

        return response()->json([
            'status' => true,
            'message' => 'Notices retrieved successfully.',
            'data' => $noticesWithNo
        ]);
    }




    // Fetch a specific notice by ID (ID comes from the input body)
    public function show(Request $request)
    {
        // Validate the request for ID
        $validated = $request->validate([
            'id' => 'required|integer|exists:notices,id', // Validate ID
        ]);

        // Retrieve the notice by ID
        $notice = Notice::findOrFail($request->id);

        return response()->json([
            'status' => true,
            'message' => 'Notice retrieved successfully.',
            'data' => [
                'no' => 1,  // Consistent index for a single notice
                'id' => $notice->id,
                'notice_title' => $notice->notice_title,
                'notice_desc' => $notice->notice_desc,
                'date' => \Carbon\Carbon::parse($notice->date)->format('d-m-Y'),
                'time' => $notice->time,
                'status' => $notice->status,
                'documents' => $notice->documents ? array_map(function ($document) {
                    return asset('storage/' . $document); // Generate URL for each document in the array
                }, json_decode($notice->documents)) : [], // If documents is null, return an empty array
            ]
        ]);
    }


    // Update a specific notice by ID (ID comes from the input body)
    // public function update(Request $request)
    // {
    //     $validated = $request->validate([
    //         'id' => 'required|integer|exists:notices,id', // Validate ID
    //         'notice_title' => 'sometimes|required|string|max:255',
    //         'notice_desc' => 'sometimes|required|string',
    //         'date' => 'sometimes|required|date',
    //         'time' => 'sometimes|required|date_format:H:i:s',
    //         'status' => 'sometimes|required|in:active,deactive',
    //         'documents' => 'nullable|array',  // documents can be updated
    //     ]);

    //     // Retrieve the notice by ID
    //     $notice = Notice::findOrFail($request->id);

    //     // Handle documents URLs if provided
    //     if ($request->has('documents') && is_array($request->documents)) {
    //         $documentUrls = array_map(function ($document) {
    //             return env('APP_URL') . '/storage/notice_documents/' . $document;
    //         }, $request->documents);
    //     } else {
    //         $documentUrls = [];
    //     }

    //     // Update the notice with the new data
    //     $notice->update([
    //         'notice_title' => $request->notice_title ?? $notice->notice_title,
    //         'notice_desc' => $request->notice_desc ?? $notice->notice_desc,
    //         'date' => $request->date ?? $notice->date,
    //         'time' => $request->time ?? $notice->time,
    //         'status' => $request->status ?? $notice->status,
    //         'documents' => json_encode($documentUrls), // Update documents field
    //     ]);

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Notice updated successfully.',
    //         'data' => $notice
    //     ]);
    // }

    public function update(Request $request)
    {
        // Ensure the user has role_id 1 or 2 to update a notice
        $user = auth()->user();
        if (!in_array($user->role_id, [1, 2])) {
            return response()->json([
                'status' => false,
                'message' => 'You do not have permission to update notices.',
            ], 403);
        }

        // Validate required field: only id is mandatory
        $validated = $request->validate([
            'id' => 'required|integer|exists:notices,id', // Validate ID
            'notice_title' => 'nullable|string|max:255',
            'notice_desc' => 'nullable|string',
            'date' => 'nullable|date',
            'time' => 'nullable|date_format:H:i:s',
            'status' => 'nullable|in:active,deactive',
            'documents' => 'nullable',  // documents can be updated
        ]);

        // Retrieve the notice by ID
        $notice = Notice::findOrFail($request->id);

        // Handle document uploads if provided
        $documentPaths = json_decode($notice->documents, true) ?: []; // Keep existing documents if not updated
        if ($request->hasFile('documents')) {
            // If it's multiple files
            if (is_array($request->file('documents'))) {
                foreach ($request->file('documents') as $document) {
                    // Store each document and get the path
                    $documentPath = $this->storeFileInPublicFolder($document, 'documents');
                    $documentPaths[] = $documentPath;
                }
            } else {
                // If it's a single file
                $documentPath = $this->storeFileInPublicFolder($request->file('documents'), 'notice_documents');
                $documentPaths[] = $documentPath;
            }
        }

        // Update the notice with the new data only for provided fields
        $notice->update([
            'notice_title' => $request->notice_title ?? $notice->notice_title,
            'notice_desc' => $request->notice_desc ?? $notice->notice_desc,
            'date' => $request->date ??  \Carbon\Carbon::parse($notice->date)->format('Y-m-d'),
            'time' => $request->time ?? $notice->time,
            'status' => $request->status ?? $notice->status,
            'documents' => json_encode($documentPaths), // Update documents field
            'society_id' => $user->society_id, // Ensure society_id remains consistent with the authenticated user's society_id
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Notice updated successfully.',
            'data' => $notice
        ]);
    }


    // Delete a specific notice by ID (ID comes from the input body)
    public function destroy(Request $request)
    {
        // Validate the request for ID
        $validated = $request->validate([
            'id' => 'required|integer|exists:notices,id', // Validate ID
        ]);

        // Retrieve the notice by ID and delete it
        $notice = Notice::findOrFail($request->id);
        $notice->delete();

        return response()->json([
            'status' => true,
            'message' => 'Notice deleted successfully.',
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
