<?php

namespace App\Http\Controllers;

use App\Models\Designation;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DesignationController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role_name' => 'required|string|max:255|unique:designations,role_name,NULL,id,society_id,' . auth()->user()->society_id,
            'status' => 'nullable|in:active,deactive',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Required parameter(s) are missing or invalid.',
                'data' => $validator->errors()
            ], 200);
        }

        $status = $request->status ?? 'active';
        $society_id = auth()->user()->society_id;
        Log::info('Logged-in User Society ID: ' . $society_id);
        if (!$society_id) {
            return response()->json([
                'status' => false,
                'message' => 'Logged-in user does not have a valid society.',
            ], 400);
        }
        $role = Designation::create([
            'role_name' => $request->role_name,
            'status' => $status,
            'society_id' => $society_id,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Role created successfully.',
            'data' => $role,
        ], 200);
    }
    public function index(Request $request)
    {

        $user = auth()->user();
        $society_id = $user->society_id;

        $roles = Designation::where('society_id', $society_id)->get();
        $roles = $roles->map(function ($role, $index) {
            $role->no = $index + 1;
            return $role;
        });

        return response()->json([
            'status' => true,
            'message' => 'Roles retrieved successfully.',
            'data' => $roles,
        ], 200);
    }
    public function show(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:designations,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => true,
                'message' => 'Required parameter(s) are missing or invalid.',
                'data' => $validator->errors()
            ], 200);
        }
        $user = auth()->user();
        $society_id = $user->society_id;
        $role = Designation::where('id', $request->id)->where('society_id', $society_id)->first();

        if (!$role) {
            return response()->json([
                'status' => false,
                'message' => 'Role not found for this society.',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Role retrieved successfully.',
            'data' => $role,
        ], 200);
    }
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:designations,id',
            'role_name' => 'required|string|unique:designations,role_name,' . $request->id . '|max:255',
            'status' => 'required|in:active,deactive',
            'society_id' => 'required|exists:societies,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => true,
                'message' => 'Required parameter(s) are missing or invalid.',
                'data' => $validator->errors()
            ], 200);
        }
        $user = auth()->user();
        $society_id = $user->society_id;
        $role = Designation::where('id', $request->id)->where('society_id', $society_id)->first();

        if (!$role) {
            return response()->json([
                'status' => false,
                'message' => 'Role not found for this society.',
            ], 404);
        }
        $role->role_name = $request->role_name;
        $role->status = $request->status;
        $role->society_id = $request->society_id;
        $role->save();

        return response()->json([
            'status' => true,
            'message' => 'Role updated successfully.',
            'data' => $role,
        ], 200);
    }
    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:designations,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => true,
                'message' => 'Required parameter(s) are missing or invalid.',
                'data' => $validator->errors()
            ], 200);
        }
        $user = auth()->user();
        $society_id = $user->society_id;
        $role = Designation::where('id', $request->id)->where('society_id', $society_id)->first();

        if (!$role) {
            return response()->json([
                'status' => false,
                'message' => 'Role not found for this society.',
            ], 404);
        }

        $role->delete();

        return response()->json([
            'status' => true,
            'message' => 'Role deleted successfully.',
        ], 200);
    }
}
