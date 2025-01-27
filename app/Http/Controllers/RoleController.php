<?php

// namespace App\Http\Controllers;

// use App\Models\Role;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Validator;

// class RoleController extends Controller
// {
//     public function create(Request $request)
//     {
//         $validator = Validator::make($request->all(), [
//             'role_name' => 'required|string|unique:roles,role_name|max:255', // role_name is required
//             'status' => 'nullable|in:active,deactive', // status is optional and should be either active or deactive
//         ]);

//         if ($validator->fails()) {
//             return response()->json([
//                 'status' => true,
//                 'message' => 'Required parameter(s) are missing or invalid.',
//                 'data' => $validator->errors()
//             ], 200);
//         }

//         // Set default value for status if not provided
//         $status = $request->status ?? 'active';

//         // Create the role
//         $role = Role::create([
//             'role_name' => $request->role_name,
//             'status' => $status, // Use default status if not provided
//         ]);

//         return response()->json([
//             'status' => true,
//             'message' => 'Role created successfully.',
//             'data' => $role,
//         ], 200);
//     }


//     // Get all roles
//     public function index(Request $request)
//     {
//         $roles = Role::all();

//         // Add "no" field for indexing
//         $roles = $roles->map(function ($role, $index) {
//             $role->no = $index + 1; // Index starts from 1
//             return $role;
//         });

//         return response()->json([
//             'status' => true,
//             'message' => 'Roles retrieved successfully.',
//             'data' => $roles,
//         ], 200);
//     }


//     // Get a specific role by id
//     public function show(Request $request)
//     {
//         $validator = Validator::make($request->all(), [
//             'id' => 'required|exists:roles,id',
//         ]);

//         if ($validator->fails()) {
//             return response()->json([
//                 'status' => true,
//                 'message' => 'Required parameter(s) are missing or invalid.',
//                 'data' => $validator->errors()
//             ], 200);
//         }

//         $role = Role::find($request->id);

//         return response()->json([
//             'status' => true,
//             'message' => 'Role retrieved successfully.',
//             'data' => $role,
//         ], 200);
//     }

//     // Update an existing role
//     public function update(Request $request)
//     {
//         $validator = Validator::make($request->all(), [
//             'id' => 'required|exists:roles,id',
//             'role_name' => 'required|string|unique:roles,role_name,' . $request->id . '|max:255',
//             'status' => 'required|in:active,deactive',
//         ]);

//         if ($validator->fails()) {
//             return response()->json([
//                 'status' => true,
//                 'message' => 'Required parameter(s) are missing or invalid.',
//                 'data' => $validator->errors()
//             ], 200);
//         }

//         $role = Role::find($request->id);
//         $role->role_name = $request->role_name;
//         $role->status = $request->status;
//         $role->save();

//         return response()->json([
//             'status' => true,
//             'message' => 'Role updated successfully.',
//             'data' => $role,
//         ], 200);
//     }

//     // Delete a specific role
//     public function destroy(Request $request)
//     {
//         $validator = Validator::make($request->all(), [
//             'id' => 'required|exists:roles,id',
//         ]);

//         if ($validator->fails()) {
//             return response()->json([
//                 'status' => true,
//                 'message' => 'Required parameter(s) are missing or invalid.',
//                 'data' => $validator->errors()
//             ], 200);
//         }

//         $role = Role::find($request->id);
//         $role->delete();

//         return response()->json([
//             'status' => true,
//             'message' => 'Role deleted successfully.',
//         ], 200);
//     }
// }



namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role_name' => 'required|string|max:255|unique:roles,role_name,NULL,id,society_id,' . auth()->user()->society_id, // Add unique constraint based on role_name and society_id
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

        // Get society_id from logged-in user
        $society_id = auth()->user()->society_id;

        // Debugging log
        \Log::info('Logged-in User Society ID: ' . $society_id);

        // Check if society_id is valid
        if (!$society_id) {
            return response()->json([
                'status' => false,
                'message' => 'Logged-in user does not have a valid society.',
            ], 400);
        }

        // Create the role and associate it with the society_id
        $role = Role::create([
            'role_name' => $request->role_name,
            'status' => $status,
            'society_id' => $society_id, // Ensure the correct society_id is passed
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Role created successfully.',
            'data' => $role,
        ], 200);
    }




    // Get all roles for the logged-in user's society
    public function index(Request $request)
    {
        // Get the logged-in user's society_id
        $user = auth()->user();
        $society_id = $user->society_id;

        $roles = Role::where('society_id', $society_id)->get(); // Filter roles by society_id

        // Add "no" field for indexing
        $roles = $roles->map(function ($role, $index) {
            $role->no = $index + 1; // Index starts from 1
            return $role;
        });

        return response()->json([
            'status' => true,
            'message' => 'Roles retrieved successfully.',
            'data' => $roles,
        ], 200);
    }

    // Get a specific role by id
    public function show(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:roles,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => true,
                'message' => 'Required parameter(s) are missing or invalid.',
                'data' => $validator->errors()
            ], 200);
        }

        // Get the logged-in user's society_id
        $user = auth()->user();
        $society_id = $user->society_id;

        // Find the role and ensure it belongs to the same society as the logged-in user
        $role = Role::where('id', $request->id)->where('society_id', $society_id)->first();

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

    // Update an existing role
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:roles,id',
            'role_name' => 'required|string|unique:roles,role_name,' . $request->id . '|max:255',
            'status' => 'required|in:active,deactive',
            'society_id' => 'required|exists:societies,id', // Ensure society_id is passed and valid
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => true,
                'message' => 'Required parameter(s) are missing or invalid.',
                'data' => $validator->errors()
            ], 200);
        }

        // Get the logged-in user's society_id
        $user = auth()->user();
        $society_id = $user->society_id;

        // Ensure the role belongs to the same society as the logged-in user
        $role = Role::where('id', $request->id)->where('society_id', $society_id)->first();

        if (!$role) {
            return response()->json([
                'status' => false,
                'message' => 'Role not found for this society.',
            ], 404);
        }

        // Update the role
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

    // Delete a specific role
    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:roles,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => true,
                'message' => 'Required parameter(s) are missing or invalid.',
                'data' => $validator->errors()
            ], 200);
        }

        // Get the logged-in user's society_id
        $user = auth()->user();
        $society_id = $user->society_id;

        // Ensure the role belongs to the same society as the logged-in user
        $role = Role::where('id', $request->id)->where('society_id', $society_id)->first();

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
