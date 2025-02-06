<?php

namespace App\Http\Controllers;

use App\Models\Designation;
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

        $validator = Validator::make($request->all(), [
            'role_id' => 'required|exists:designations,id',
            'user_id' => 'required|exists:users,id',
            'profile_image' => 'nullable|string',
            'mobile' => 'nullable|string|max:15',
            'block_number' => 'nullable|string|max:50',
            'first_name' => 'nullable|string|max:50',
            'last_name' => 'nullable|string|max:50',
            'status' => 'nullable|in:active,deactive',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Required parameter(s) are missing or invalid.',
                'data' => $validator->errors(),
            ], 200);
        }
        $role = Designation::find($request->role_id);
        $user = User::find($request->user_id);
        if ($role->society_id != auth()->user()->society_id) {
            return response()->json([
                'status' => false,
                'message' => "You do not have permission to create a role member for this role.",
            ], 403);
        }
        $status = $request->status ?? 'active';
        $roleMember = RoleMember::create([
            'role_id' => $request->role_id,
            'role_name' => $role->role_name,
            'user_id' => $request->user_id,
            'profile_image' => $user->profile_image,
            'mobile' => $user->mobile,
            'block_number' => $user->block_number,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'status' => $status,
        ]);
        $formattedData = [
            'no' => 1,
            'id' => $roleMember->id,
            'blockNumber' => $roleMember->block_number,
            'image' => $roleMember->profile_image
                ? env('APP_URL') . '/public/storage/' . $roleMember->profile_image
                : config('app.url') . '/public/storage/profile_photos/avatar.png',
            'ownerName' => $roleMember->first_name . ' ' . $roleMember->last_name,
            'role' => $roleMember->role_name,
            'mobile' => $roleMember->mobile,
        ];

        return response()->json([
            'status' => true,
            'message' => 'Role member created successfully.',
            'data' => [$formattedData],
        ], 200);
    }
    public function index(Request $request)
    {

        $societyId = auth()->user()->society_id;
        $roleMembers = RoleMember::whereHas('role', function ($query) use ($societyId) {
            $query->where('society_id', $societyId);
        })->get();
        $roleMembers = $roleMembers->map(function ($roleMember, $index) {

            $formattedData = [
                'no' => $index + 1,
                'id' => $roleMember->id,
                'blockNumber' => $roleMember->block_number,
                'image' => $roleMember->profile_image
                    ? config('app.url') . '/public/storage/' . $roleMember->profile_image
                    : config('app.url') . '/public/storage/profile_photos/avatar.png',
                'ownerName' => $roleMember->first_name . ' ' . $roleMember->last_name,
                'role' => $roleMember->role_name,
                'mobile' => $roleMember->mobile,
            ];
            return (object) $formattedData;
        });

        return response()->json([
            'status' => true,
            'message' => 'Role members retrieved successfully.',
            'data' => $roleMembers,
        ], 200);
    }
    public function show(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'nullable|exists:role_members,id',
            'role_id' => 'nullable|exists:designations,id',
            'user_id' => 'nullable|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Required parameter(s) are missing or invalid.',
                'data' => $validator->errors(),
            ], 200);
        }
        $formatMember = function ($roleMember, $index) {
            return [
                'no' => $index + 1,
                'id' => $roleMember->id,
                'blockNumber' => $roleMember->block_number,
                'image' => $roleMember->profile_image
                    ? env('APP_URL') . '/public/storage/' . $roleMember->profile_image
                    : config('app.url') . '/public/storage/profile_photos/avatar.png',
                'ownerName' => $roleMember->first_name . ' ' . $roleMember->last_name,
                'role' => $roleMember->role_name,
                'mobile' => $roleMember->mobile,
            ];
        };
        if ($request->has('id')) {
            $roleMember = RoleMember::find($request->id);
            if (!$roleMember) {
                return response()->json([
                    'status' => false,
                    'message' => 'Role member not found.',
                ], 200);
            }
            $role = Designation::find($roleMember->role_id);
            if ($role->society_id != auth()->user()->society_id) {
                return response()->json([
                    'status' => false,
                    'message' => "You do not have permission to view this role member.",
                ], 403);
            }

            $formattedMember = $formatMember($roleMember, 0);

            return response()->json([
                'status' => true,
                'message' => 'Role member retrieved successfully.',
                'data' => [$formattedMember],
            ], 200);
        }
        if ($request->has('role_id')) {
            $role = Designation::find($request->role_id);

            if ($role->society_id != auth()->user()->society_id) {
                return response()->json([
                    'status' => false,
                    'message' => "You do not have permission to view role members for this role.",
                ], 403);
            }

            $roleMembers = RoleMember::where('role_id', $request->role_id)->get();
            if ($roleMembers->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'No role members found for this role.',
                ], 200);
            }

            $formattedMembers = $roleMembers->map($formatMember);

            return response()->json([
                'status' => true,
                'message' => 'Role members retrieved successfully.',
                'data' => $formattedMembers,
            ], 200);
        }
        if ($request->has('user_id')) {
            $roleMembers = RoleMember::where('user_id', $request->user_id)->get();
            if ($roleMembers->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'No role members found for this user.',
                ], 200);
            }
            $roleMembers = $roleMembers->filter(function ($roleMember) {
                $role = Designation::find($roleMember->role_id);
                return $role && $role->society_id == auth()->user()->society_id;
            });

            if ($roleMembers->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'No role members found for this user in your society.',
                ], 200);
            }

            $formattedMembers = $roleMembers->map($formatMember);

            return response()->json([
                'status' => true,
                'message' => 'Role members retrieved successfully.',
                'data' => $formattedMembers,
            ], 200);
        }

        return response()->json([
            'status' => false,
            'message' => 'No valid parameter provided.',
        ], 200);
    }
    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:role_members,id',
            'role_id' => 'nullable|exists:designations,id',
            'user_id' => 'nullable|exists:users,id',
            'status' => 'nullable|in:active,deactive',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => true,
                'message' => 'Required parameter(s) are missing or invalid.',
                'data' => $validator->errors(),
            ], 200);
        }
        $roleMember = RoleMember::find($request->id);
        if ($request->has('role_id')) {
            $roleMember->role_id = $request->role_id;
            $roleMember->role_name = Designation::find($request->role_id)->role_name;
        }
        if ($request->has('user_id')) {
            $roleMember->user_id = $request->user_id;
            $user = User::find($request->user_id);
            $roleMember->mobile = $user->mobile;
            $roleMember->block_number = $user->block_number;
            $roleMember->first_name = $user->first_name;
            $roleMember->last_name = $user->last_name;
            $roleMember->profile_image = $user->profile_photo;
        }
        if ($request->has('status')) {
            $roleMember->status = $request->status;
        }
        $roleMember->save();
        $formattedData = [
            'no' => 1,
            'id' => $roleMember->id,
            'blockNumber' => $roleMember->block_number,
            'image' => $roleMember->profile_image
                ? env('APP_URL') . '/public/storage/' . $roleMember->profile_image
                : config('app.url') . '/public/storage/profile_photos/avatar.png',
            'ownerName' => $roleMember->first_name . ' ' . $roleMember->last_name,
            'role' => $roleMember->role_name,
            'mobile' => $roleMember->mobile,

        ];

        return response()->json([
            'status' => true,
            'message' => 'Role member updated successfully.',
            'data' => [$formattedData],
        ], 200);
    }
    public function destroy(Request $request)
    {

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
        $formattedData = function ($roleMember) {
            return [
                'no' => 1,
                'id' => $roleMember->id,
                'blockNumber' => $roleMember->block_number,
                'image' => $roleMember->profile_image
                    ? env('APP_URL') . '/public/storage/' . $roleMember->profile_image
                    :  config('app.url') . '/public/storage/profile_photos/avatar.png',
                'ownerName' => $roleMember->first_name . ' ' . $roleMember->last_name,
                'role' => $roleMember->role_name,
                'mobile' => $roleMember->mobile,
            ];
        };
        if ($request->has('id')) {
            $roleMember = RoleMember::find($request->id);
            if ($roleMember) {
                $role = Designation::find($roleMember->role_id);
                if ($role->society_id != auth()->user()->society_id) {
                    return response()->json([
                        'status' => false,
                        'message' => "You do not have permission to delete this role member.",
                    ], 403);
                }
            }

            $roleMemberData = $formattedData($roleMember);
            $roleMember->delete();

            return response()->json([
                'status' => true,
                'message' => 'Role member deleted successfully by id.',
                'data' => [$roleMemberData],
            ], 200);
        }
        if ($request->has('user_id')) {
            $roleMembers = RoleMember::where('user_id', $request->user_id)->get();
            foreach ($roleMembers as $roleMember) {
                $role = Designation::find($roleMember->role_id);
                if ($role->society_id != auth()->user()->society_id) {
                    return response()->json([
                        'status' => false,
                        'message' => "You do not have permission to delete role members for this user.",
                    ], 403);
                }
            }

            $roleMembersData = $roleMembers->map(function ($roleMember) use ($formattedData) {
                return $formattedData($roleMember);
            });
            RoleMember::where('user_id', $request->user_id)->delete();

            return response()->json([
                'status' => true,
                'message' => 'Role members deleted successfully by user_id.',
                'data' => $roleMembersData,
            ], 200);
        }
        if ($request->has('role_id')) {
            $roleMembers = RoleMember::where('role_id', $request->role_id)->get();
            foreach ($roleMembers as $roleMember) {
                $role = Designation::find($roleMember->role_id);
                if ($role->society_id != auth()->user()->society_id) {
                    return response()->json([
                        'status' => false,
                        'message' => "You do not have permission to delete role members for this role.",
                    ], 403);
                }
            }

            $roleMembersData = $roleMembers->map(function ($roleMember) use ($formattedData) {
                return $formattedData($roleMember);
            });
            RoleMember::where('role_id', $request->role_id)->delete();

            return response()->json([
                'status' => true,
                'message' => 'Role members deleted successfully by role_id.',
                'data' => $roleMembersData,
            ], 200);
        }
        return response()->json([
            'status' => false,
            'message' => 'No valid parameter provided for deletion.',
        ], 200);
    }
}
