<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notice;

class NoticeController extends Controller
{
    // Store a newly created notice (with documents)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'notice_title' => 'required|string|max:255',
            'notice_desc' => 'required|string',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i:s',
            'status' => 'required|in:active,deactive',
            'documents' => 'nullable|array',  // documents should be an array of URLs
        ]);

        // Generate the document URLs (if documents are provided)
        if ($request->has('documents') && is_array($request->documents)) {
            $documentUrls = array_map(function ($document) {
                return env('APP_URL') . '/storage/notice_documents/' . $document; // Construct the full URL
            }, $request->documents);
        } else {
            $documentUrls = [];
        }

        // Create the notice with the documents URLs
        $notice = Notice::create([
            'notice_title' => $request->notice_title,
            'notice_desc' => $request->notice_desc,
            'date' => $request->date,
            'time' => $request->time,
            'status' => $request->status,
            'documents' => json_encode($documentUrls), // Store the URLs as a JSON array
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Notice created successfully.',
            'data' => $notice
        ], 201);
    }

    // Fetch all notices (accepting POST request)
    public function index(Request $request)
    {
        // Retrieve all notices
        $notices = Notice::all();

        // Map the notices to include a consistent "no" index
        $noticesWithNo = $notices->map(function ($notice, $index) {
            return [
                'no' => $index + 1,  // Provide a consistent index number starting from 1
                'id' => $notice->id,
                'notice_title' => $notice->notice_title,
                'notice_desc' => $notice->notice_desc,
                'date' => $notice->date,
                'time' => $notice->time,
                'status' => $notice->status,
                'documents' => json_decode($notice->documents), // Convert documents URL array back to array
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
                'date' => $notice->date,
                'time' => $notice->time,
                'status' => $notice->status,
                'documents' => json_decode($notice->documents),
            ]
        ]);
    }

    // Update a specific notice by ID (ID comes from the input body)
    public function update(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|integer|exists:notices,id', // Validate ID
            'notice_title' => 'sometimes|required|string|max:255',
            'notice_desc' => 'sometimes|required|string',
            'date' => 'sometimes|required|date',
            'time' => 'sometimes|required|date_format:H:i:s',
            'status' => 'sometimes|required|in:active,deactive',
            'documents' => 'nullable|array',  // documents can be updated
        ]);

        // Retrieve the notice by ID
        $notice = Notice::findOrFail($request->id);

        // Handle documents URLs if provided
        if ($request->has('documents') && is_array($request->documents)) {
            $documentUrls = array_map(function ($document) {
                return env('APP_URL') . '/storage/notice_documents/' . $document;
            }, $request->documents);
        } else {
            $documentUrls = [];
        }

        // Update the notice with the new data
        $notice->update([
            'notice_title' => $request->notice_title ?? $notice->notice_title,
            'notice_desc' => $request->notice_desc ?? $notice->notice_desc,
            'date' => $request->date ?? $notice->date,
            'time' => $request->time ?? $notice->time,
            'status' => $request->status ?? $notice->status,
            'documents' => json_encode($documentUrls), // Update documents field
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
}
