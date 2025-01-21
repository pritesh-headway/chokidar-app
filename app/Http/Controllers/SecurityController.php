<?php


namespace App\Http\Controllers;

use App\Models\Security;
use Illuminate\Http\Request;

class SecurityController extends Controller
{
    // Display a listing of the securities (by user_id if provided)
    public function index(Request $request)
    {
        $query = Security::query();

        if ($request->has('id') && $request->id !== 'all') {
            $query->where('id', $request->id);
        }

        $securities = $query->get();
        return response()->json($securities);
    }

    public function store(Request $request)
    {
        // Validate the request and ensure missing fields are captured
        $validatedData = $request->validate([
            'guard_name' => 'required|string|max:50',
            'mobile' => 'required|string|max:20',  // Assuming mobile is a string (VARCHAR)
            'address' => 'required|string|max:255',
            'gate_no' => 'required|integer',
            'details' => 'required|string',
            'guard_image' => 'required|string|max:256', // Image URL or path
            'documents' => 'required|array',  // Array of document paths or URLs
            'status' => 'nullable|in:active,deactive',  // Status is nullable and will default to 'deactive'
        ]);

        // If validation fails (empty body or missing fields), Laravel will automatically return validation errors
        // However, we customize the response format to include both message and missing fields

        // Check if 'status' is not provided and set the default value to 'deactive'
        $status = $request->get('status', 'deactive'); // Default to 'deactive'

        // Create the new security record if validation passes
        $security = Security::create([
            'guard_name' => $request->guard_name,
            'mobile' => $request->mobile,
            'address' => $request->address,
            'gate_no' => $request->gate_no,
            'details' => $request->details,
            'guard_image' => $request->guard_image,
            'documents' => json_encode($request->documents), // Assuming documents are being passed as an array
            'status' => $status,
        ]);

        return response()->json(['message' => 'Security record created successfully.', 'data' => $security], 201);
    }



    // Show a specific security record
    public function show($id)
    {
        $security = Security::findOrFail($id);
        return response()->json($security);
    }

    // Update a specific security record
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'guard_name' => 'nullable|string|max:50',
            'mobile' => 'nullable|integer',
            'address' => 'nullable|string|max:255',
            'gate_no' => 'nullable|integer',
            'details' => 'nullable|string',
            'guard_image' => 'nullable|string|max:256',
            'documents' => 'nullable|array',
            'status' => 'nullable|in:active,deactive',
        ]);

        $security = Security::findOrFail($id);
        $security->update($validatedData);

        return response()->json(['message' => 'Security updated successfully.', 'data' => $security]);
    }

    // Delete a specific security record
    public function destroy($id)
    {
        $security = Security::findOrFail($id);
        $security->delete();

        return response()->json(['message' => 'Security deleted successfully.']);
    }
}
