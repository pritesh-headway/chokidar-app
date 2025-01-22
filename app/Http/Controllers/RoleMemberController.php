<?php

namespace App\Http\Controllers;

use App\Models\RoleMember;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class RoleMemberController extends Controller
{
    public function store(Request $request)
    {
        // Validate only the required fields for role member creation
        $validator = Validator::make($request->all(), [
            'role_id' => 'required|exists:roles,id', // role_id is required and must exist in the roles table
            'user_id' => 'required|exists:users,id', // user_id is required and must exist in the users table
            'profile_image' => 'nullable|string', // profile_image is optional
            'mobile' => 'nullable|string|max:15', // mobile is optional
            'block_number' => 'nullable|string|max:50', // block_number is optional
            'first_name' => 'nullable|string|max:50', // first_name is optional
            'last_name' => 'nullable|string|max:50', // last_name is optional
            'status' => 'nullable|in:active,deactive', // status is optional and should be either active or deactive
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => true,
                'message' => 'Required parameter(s) are missing or invalid.',
                'data' => $validator->errors(),
            ], 200);
        }

        // Retrieve the role and user from the database
        $role = Role::find($request->role_id);
        $user = User::find($request->user_id);

        // Set default value for status if not provided
        $status = $request->status ?? 'active';

        // Create the role member
        $roleMember = RoleMember::create([
            'role_id' => $request->role_id,
            'role_name' => $role->role_name, // Automatically taken from roles table using role_id
            'user_id' => $request->user_id,
            'profile_image' => $request->profile_image,
            'mobile' => $user->mobile, // Taken from users table using user_id
            'block_number' => $user->block_number, // Taken from users table using user_id
            'first_name' => $user->first_name, // Taken from users table using user_id
            'last_name' => $user->last_name, // Taken from users table using user_id
            'status' => $status, // Use default status if not provided
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Role member created successfully.',
            'data' => $roleMember,
        ], 200);
    }


    public function index(Request $request)
    {
        $roleMembers = RoleMember::all();

        // Add 'no', 'member_name', and format profile image for each role member
        $roleMembers = $roleMembers->map(function ($roleMember, $index) {
            $roleMember->no = $index + 1; // Add indexing
            $roleMember->member_name = $roleMember->first_name . ' ' . $roleMember->last_name; // Concatenate names
            unset($roleMember->first_name, $roleMember->last_name); // Remove individual names
            // Ensure full URL for profile image
            if ($roleMember->profile_image) {
                // $roleMember->profile_image = env('APP_URL') . '/public' . Storage::url($roleMember->profile_image);
                // dd($roleMember->profile_image);
                $roleMember->profile_image = env('APP_URL') . '/public/storage/' . $roleMember->profile_image;
            }
            return $roleMember;
        });

        return response()->json([
            'status' => true,
            'message' => 'Role members retrieved successfully.',
            'data' => $roleMembers,
        ], 200);
    }

    public function show(Request $request)
    {
        // Validate input for any of the possible parameters
        $validator = Validator::make($request->all(), [
            'id' => 'nullable|exists:role_members,id',
            'role_id' => 'nullable|exists:roles,id',
            'user_id' => 'nullable|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => true,
                'message' => 'Required parameter(s) are missing or invalid.',
                'data' => $validator->errors(),
            ], 200);
        }

        // Helper function to add member_name and full URL for profile image
        $formatMember = function ($roleMember) {
            $roleMember->member_name = $roleMember->first_name . ' ' . $roleMember->last_name;
            unset($roleMember->first_name, $roleMember->last_name); // Remove individual names
            if ($roleMember->profile_image) {
                $roleMember->profile_image = env('APP_URL') . '/public/storage/' . $roleMember->profile_image; // Full URL to image
            }
            return $roleMember;
        };

        // If id is provided
        if ($request->has('id')) {
            $roleMember = RoleMember::find($request->id);
            if (!$roleMember) {
                return response()->json([
                    'status' => false,
                    'message' => 'Role member not found.',
                ], 404);
            }
            $roleMember = $formatMember($roleMember);

            return response()->json([
                'status' => true,
                'message' => 'Role member retrieved successfully.',
                'data' => $roleMember,
            ], 200);
        }

        // If role_id is provided
        if ($request->has('role_id')) {
            $roleMembers = RoleMember::where('role_id', $request->role_id)->get();
            if ($roleMembers->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'No role members found for this role.',
                ], 404);
            }

            $roleMembers->each($formatMember);

            return response()->json([
                'status' => true,
                'message' => 'Role members retrieved successfully.',
                'data' => $roleMembers,
            ], 200);
        }

        // If user_id is provided
        if ($request->has('user_id')) {
            $roleMembers = RoleMember::where('user_id', $request->user_id)->get();
            if ($roleMembers->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'No role members found for this user.',
                ], 404);
            }

            $roleMembers->each($formatMember);

            return response()->json([
                'status' => true,
                'message' => 'Role members retrieved successfully.',
                'data' => $roleMembers,
            ], 200);
        }

        return response()->json([
            'status' => false,
            'message' => 'No valid parameter provided.',
        ], 400);
    }


    public function update(Request $request)
    {
        // Validate that only the 'id' field is required
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:role_members,id', // Ensure id exists in the role_members table
            'role_id' => 'nullable|exists:roles,id', // role_id is optional, but if provided, it should exist in roles table
            'user_id' => 'nullable|exists:users,id', // user_id is optional, but if provided, it should exist in users table
            'status' => 'nullable|in:active,deactive', // status is optional, but if provided, it should be either active or deactive
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => true,
                'message' => 'Required parameter(s) are missing or invalid.',
                'data' => $validator->errors(),
            ], 200);
        }

        // Find the role member by id
        $roleMember = RoleMember::find($request->id);

        // If role_id is provided, update it, else keep the old value
        if ($request->has('role_id')) {
            $roleMember->role_id = $request->role_id;
            $roleMember->role_name = Role::find($request->role_id)->role_name; // Update the role_name
        }

        // If user_id is provided, update it, else keep the old value
        if ($request->has('user_id')) {
            $roleMember->user_id = $request->user_id;
            $user = User::find($request->user_id);
            $roleMember->mobile = $user->mobile;
            $roleMember->block_number = $user->block_number;
            $roleMember->first_name = $user->first_name;
            $roleMember->last_name = $user->last_name;
            $roleMember->profile_image = $user->profile_photo; // Update profile_image
        }

        // If status is provided, update it, else keep the old value
        if ($request->has('status')) {
            $roleMember->status = $request->status;
        }

        // Save the updated role member
        $roleMember->save();

        return response()->json([
            'status' => true,
            'message' => 'Role member updated successfully.',
            'data' => $roleMember,
        ], 200);
    }


    public function destroy(Request $request)
    {
        // Validate that at least one of 'id', 'user_id', or 'role_id' is provided
        $validator = Validator::make($request->all(), [
            'id' => 'nullable|exists:role_members,id',
            'user_id' => 'nullable|exists:role_members,user_id',
            'role_id' => 'nullable|exists:role_members,role_id',
        ]);

        if ($validator->fails() || (!$request->id && !$request->user_id && !$request->role_id)) {
            return response()->json([
                'status' => true,
                'message' => 'Required parameter(s) are missing or invalid.',
                'data' => $validator->errors(),
            ], 200);
        }

        // Delete by 'id'
        if ($request->has('id')) {
            $roleMember = RoleMember::find($request->id);
            $roleMember->delete();

            return response()->json([
                'status' => true,
                'message' => 'Role member deleted successfully by id.',
            ], 200);
        }

        // Delete by 'user_id'
        if ($request->has('user_id')) {
            RoleMember::where('user_id', $request->user_id)->delete();

            return response()->json([
                'status' => true,
                'message' => 'Role members deleted successfully by user_id.',
            ], 200);
        }

        // Delete by 'role_id'
        if ($request->has('role_id')) {
            RoleMember::where('role_id', $request->role_id)->delete();

            return response()->json([
                'status' => true,
                'message' => 'Role members deleted successfully by role_id.',
            ], 200);
        }

        // If none of the conditions match, return a generic error
        return response()->json([
            'status' => false,
            'message' => 'No valid parameter provided for deletion.',
        ], 400);
    }
}
