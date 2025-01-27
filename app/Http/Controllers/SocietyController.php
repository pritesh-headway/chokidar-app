<?php

namespace App\Http\Controllers;

use App\Models\Society;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SocietyController extends Controller
{
    // Create a new society
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id,role,admin',
            'society_name' => 'required|string|max:255',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:50',
            'postal_code' => 'required|integer',
            'contact_number' => 'required|string|size:10',
            'type' => 'required|in:residential,commercial,mixed',
            'status' => 'nullable|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation errors',
                'data' => $validator->errors(),
            ], 422);
        }

        $society = Society::create([
            'user_id' => $request->user_id,
            'society_name' => $request->society_name,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'postal_code' => $request->postal_code,
            'contact_number' => $request->contact_number,
            'type' => $request->type,
            'status' => $request->status ?? 'active',
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Society created successfully',
            'data' => $society,
        ], 201);
    }

    // Get a list of all societies
    public function index(Request $request)
    {
        $societies = Society::all();

        return response()->json([
            'status' => true,
            'message' => 'Societies fetched successfully',
            'data' => $societies,
        ]);
    }

    // Get a specific society by ID
    public function show(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:societies,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation errors',
                'data' => $validator->errors(),
            ], 422);
        }

        $society = Society::find($request->id);

        return response()->json([
            'status' => true,
            'message' => 'Society fetched successfully',
            'data' => $society,
        ]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:societies,id',
            'user_id' => 'nullable|exists:users,id,role,admin',
            'society_name' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:50',
            'postal_code' => 'nullable|integer',
            'contact_number' => 'nullable|string|size:10',
            'type' => 'nullable|in:residential,commercial,mixed',
            'status' => 'nullable|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation errors',
                'data' => $validator->errors(),
            ], 422);
        }

        $society = Society::find($request->id);

        if (!$society) {
            return response()->json([
                'status' => false,
                'message' => 'Society not found',
                'data' => null,
            ], 404);
        }

        // Update only provided fields, keeping others as they are
        if ($request->has('user_id') && !empty($request->user_id)) {
            $society->user_id = $request->user_id;
        }
        if ($request->has('society_name')  && !empty($request->society_name)) {
            $society->society_name = $request->society_name;
        }
        if ($request->has('address')  && !empty($request->address)) {
            $society->address = $request->address;
        }
        if ($request->has('city')  && !empty($request->city)) {
            $society->city = $request->city;
        }
        if ($request->has('state')  && !empty($request->state)) {
            $society->state = $request->state;
        }
        if ($request->has('postal_code')  && !empty($request->postal_code)) {
            $society->postal_code = $request->postal_code;
        }
        if ($request->has('contact_number')  && !empty($request->contact_number)) {
            $society->contact_number = $request->contact_number;
        }
        if ($request->has('type')  && !empty($request->type)) {
            $society->type = $request->type;
        }
        if ($request->has('status')  && !empty($request->status)) {
            $society->status = $request->status;
        }

        $society->save();

        return response()->json([
            'status' => true,
            'message' => 'Society updated successfully',
            'data' => $society,
        ]);
    }


    // Delete a society by ID
    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:societies,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation errors',
                'data' => $validator->errors(),
            ], 422);
        }

        $society = Society::find($request->id);

        if (!$society) {
            return response()->json([
                'status' => false,
                'message' => 'Society not found',
                'data' => null,
            ], 404);
        }

        $society->delete();

        return response()->json([
            'status' => true,
            'message' => 'Society deleted successfully',
            'data' => null,
        ]);
    }
}
