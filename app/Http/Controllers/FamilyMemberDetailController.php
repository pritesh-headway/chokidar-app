<?php

namespace App\Http\Controllers;

use App\Models\FamilyMemberDetail;
use App\Models\User;
use Illuminate\Http\Request;

class FamilyMemberDetailController extends Controller
{
    public function read(Request $request)
    {

        $missingArguments = [];

        if (!$request->has('id') && !$request->has('user_id')) {
            $missingArguments[] = 'id or user_id';
        }
        if (!empty($missingArguments)) {
            return response()->json([
                'status' => false,
                'message' => 'Missing arguments',
                'data' => []
            ], 200);
        }
        if ($request->has('id')) {

            $familyMember = FamilyMemberDetail::find($request->id);
            if (!$familyMember) {
                return response()->json([
                    'status' => false,
                    'message' => 'Family member not found',
                    'data' => []
                ], 200);
            }
            $user = User::find($familyMember->user_id);
            $role = $user ? $user->role : 'Unknown';

            return response()->json([
                'status' => true,
                'message' => 'Family member fetched successfully',
                'data' => [
                    'no' => 1,
                    'blockNumber' => $familyMember->block_number,
                    'name' => $familyMember->member_name,
                    'role' => $role,
                    'mobile' => $familyMember->mobile,
                ]
            ]);
        } elseif ($request->has('user_id')) {

            if ($request->user_id === 'all') {
                $familyMembers = FamilyMemberDetail::all();
            } else {

                $familyMembers = FamilyMemberDetail::where('user_id', $request->user_id)->get();
            }

            if ($familyMembers->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'No family members found',
                    'data' => []
                ], 200);
            }
            $response = $familyMembers->map(function ($familyMember, $index) {

                $user = User::find($familyMember->user_id);
                $role = $user ? $user->role : 'Unknown';

                return [
                    'no' => $index + 1,
                    'id' => $familyMember->id,
                    'user_id' => $user->id,
                    'blockNumber' => $familyMember->block_number,
                    'name' => $familyMember->member_name,
                    'role' => $role,
                    'mobile' => $familyMember->mobile,
                ];
            });

            return response()->json([
                'status' => true,
                'message' => 'Family members fetched successfully',
                'data' => $response
            ]);
        }
    }
    public function store(Request $request)
    {

        $missingArguments = [];

        if (!$request->has('member_name')) {
            $missingArguments[] = 'member_name';
        }

        if (!$request->has('user_id') || $request->user_id === 'all') {
            $missingArguments[] = 'user_id';
        }

        if (count($missingArguments) > 0) {
            return response()->json([
                'message' => 'Missing arguments',
                'missing_arguments' => $missingArguments
            ], 400);
        }

        $validated = $request->validate([
            'member_name' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'mobile' => 'required|digits:10',
            'status' => 'nullable|string',
        ]);
        $user = User::find($validated['user_id']);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        $familyMember = new FamilyMemberDetail();
        $familyMember->member_name = $validated['member_name'];
        $familyMember->user_id = $validated['user_id'];
        $familyMember->mobile = $validated['mobile'];
        $familyMember->status = $validated['status'] ?? "active";
        $familyMember->block_number = $user->block_number;
        $familyMember->save();

        return response()->json($familyMember, 201);
    }
    public function update(Request $request)
    {
        $missingArguments = [];

        if (!$request->has('id')) {
            $missingArguments[] = 'id';
        }

        if (!$request->has('user_id') || $request->user_id === 'all') {
            $missingArguments[] = 'user_id';
        }

        if (count($missingArguments) > 0) {
            return response()->json([
                'message' => 'Missing arguments',
                'missing_arguments' => $missingArguments
            ], 400);
        }
        $request->validate([
            'id' => 'required|exists:family_member_details,id',
            'member_name' => 'nullable|string|max:50',
            'mobile' => 'nullable|string|max:15',
            'status' => 'nullable|in:active,inactive',
            'user_id' => 'nullable|exists:users,id',
        ]);
        $familyMember = FamilyMemberDetail::find($request->id);
        if (!$familyMember) {
            return response()->json(['message' => 'Family member not found'], 404);
        }
        if ($request->has('user_id')) {
            $user = User::find($request->user_id);
            if (!$user) {
                return response()->json(['message' => 'User not found'], 404);
            }
            $familyMember->user_id = $request->user_id;
            $familyMember->block_number = $user->block_number;
        }
        $familyMember->update($request->only(['member_name', 'mobile', 'status']));

        return response()->json($familyMember);
    }
    public function destroy(Request $request)
    {
        $missingArguments = [];
        if (!$request->has('id') && !$request->has('user_id')) {
            $missingArguments[] = 'id or user_id';
        }
        if ($request->has('id') && $request->has('user_id')) {
            return response()->json(['message' => 'Please provide only one argument: id or user_id'], 400);
        }

        if (count($missingArguments) > 0) {
            return response()->json([
                'message' => 'Missing arguments',
                'missing_arguments' => $missingArguments
            ], 400);
        }
        if ($request->has('id')) {
            $request->validate([
                'id' => 'required|exists:family_member_details,id',
            ]);

            $familyMember = FamilyMemberDetail::find($request->id);
            if (!$familyMember) {
                return response()->json(['message' => 'Family member not found'], 404);
            }

            $familyMember->delete();

            return response()->json(['message' => 'Family member deleted successfully']);
        }
        if ($request->has('user_id')) {
            $request->validate([
                'user_id' => 'required|exists:users,id',
            ]);

            $familyMembers = FamilyMemberDetail::where('user_id', $request->user_id)->get();
            if ($familyMembers->isEmpty()) {
                return response()->json(['message' => 'No family members found for this user'], 404);
            }
            FamilyMemberDetail::where('user_id', $request->user_id)->delete();

            return response()->json(['message' => 'All family members for the user deleted successfully']);
        }
    }
}
