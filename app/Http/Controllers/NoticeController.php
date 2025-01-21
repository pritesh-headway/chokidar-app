<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notice;

class NoticeController extends Controller
{
    // Store a newly created notice
    public function store(Request $request)
    {
        $validated = $request->validate([
            'notice_title' => 'required|string|max:255',
            'notice_desc' => 'required|string',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i:s',
            'status' => 'required|in:active,deactive',
        ]);

        $notice = Notice::create($validated);

        return response()->json($notice, 201);
    }

    // Fetch all notices
    public function index()
    {
        $notices = Notice::all();
        return response()->json($notices);
    }

    // Fetch a specific notice by ID
    public function show($id)
    {
        // $notice = Notice::findOrFail($id);

        // if (!$notice) {
        //     return response()->json(['message' => 'Notice not found'], 404);
        // }

        // return response()->json($notice);
        $vehicle = Notice::findOrFail($id);
        return response()->json($vehicle);
    }
    // Update a specific notice by ID
    public function update(Request $request, $id)
    {
        $notice = Notice::findOrFail($id);

        $validated = $request->validate([
            'notice_title' => 'sometimes|required|string|max:255',
            'notice_desc' => 'sometimes|required|string',
            'date' => 'sometimes|required|date',
            'time' => 'sometimes|required|date_format:H:i:s',
            'status' => 'sometimes|required|in:active,deactive',
        ]);

        $notice->update($validated);

        return response()->json($notice);
    }

    // Delete a specific notice by ID
    public function destroy($id)
    {
        $notice = Notice::findOrFail($id);

        $notice->delete();

        return response()->json(['message' => 'Notice deleted successfully.']);
    }
}
