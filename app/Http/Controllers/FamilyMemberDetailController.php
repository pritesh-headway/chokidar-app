<?php

namespace App\Http\Controllers;

use App\Models\FamilyMemberDetail;
use App\Models\User;
use Illuminate\Http\Request;

class FamilyMemberDetailController extends Controller
{
    public function read(Request $request)
    {
        // Check if 'id' or 'user_id' is provided
        $missingArguments = [];

        if (!$request->has('id') && !$request->has('user_id')) {
            $missingArguments[] = 'id or user_id';
        }

        // If arguments are missing, return an error message
        if (!empty($missingArguments)) {
            return response()->json([
                'status' => false,
                'message' => 'Missing arguments',
                'data' => []
            ], 200);
        }

        // Read the family member based on id or user_id
        if ($request->has('id')) {
            // Fetch specific family member by id
            $familyMember = FamilyMemberDetail::find($request->id);
            if (!$familyMember) {
                return response()->json([
                    'status' => false,
                    'message' => 'Family member not found',
                    'data' => []
                ], 200);
            }

            // Get the user associated with the family member and fetch their role
            $user = User::find($familyMember->user_id);
            $role = $user ? $user->role : 'Unknown';

            return response()->json([
                'status' => true,
                'message' => 'Family member fetched successfully',
                'data' => [
                    'no' => 1, // You can customize this based on your needs
                    'blockNumber' => $familyMember->block_number,
                    'name' => $familyMember->member_name,
                    'role' => $role,
                    'mobile' => $familyMember->mobile,
                ]
            ]);
        } elseif ($request->has('user_id')) {
            // If user_id is 'all', fetch all family members
            if ($request->user_id === 'all') {
                $familyMembers = FamilyMemberDetail::all(); // Get all family members
            } else {
                // Fetch family members by user_id
                $familyMembers = FamilyMemberDetail::where('user_id', $request->user_id)->get();
            }

            if ($familyMembers->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'No family members found',
                    'data' => []
                ], 200);
            }

            // Format the response
            $response = $familyMembers->map(function ($familyMember, $index) {
                // Get the user associated with the family member and fetch their role
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
        // Validate the incoming data
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
            'user_id' => 'required|exists:users,id',  // Ensure the user_id exists in the users table
            'mobile' => 'required|digits:10',  // Validate mobile number
            'status' => 'nullable|string',
        ]);

        // Fetch the block_number from the users table based on user_id
        $user = User::find($validated['user_id']);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Create the family member record with the block_number from the user
        $familyMember = new FamilyMemberDetail();
        $familyMember->member_name = $validated['member_name'];
        $familyMember->user_id = $validated['user_id'];
        $familyMember->mobile = $validated['mobile'];
        $familyMember->status = $validated['status'] ?? "active";
        $familyMember->block_number = $user->block_number; // Set the block_number from the user table
        $familyMember->save();

        return response()->json($familyMember, 201); // Return the created family member details
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

        // Validate the incoming data
        $request->validate([
            'id' => 'required|exists:family_member_details,id',
            'member_name' => 'nullable|string|max:50',
            'mobile' => 'nullable|string|max:15',
            'status' => 'nullable|in:active,inactive',
            'user_id' => 'nullable|exists:users,id',  // Ensure valid user_id if provided
        ]);

        // Find the family member by ID
        $familyMember = FamilyMemberDetail::find($request->id);
        if (!$familyMember) {
            return response()->json(['message' => 'Family member not found'], 404);
        }

        // If user_id is provided and valid, update the user_id and other fields
        if ($request->has('user_id')) {
            $user = User::find($request->user_id);
            if (!$user) {
                return response()->json(['message' => 'User not found'], 404);
            }
            $familyMember->user_id = $request->user_id;
            $familyMember->block_number = $user->block_number; // Update block_number if user_id changes
        }

        // Update the rest of the fields
        $familyMember->update($request->only(['member_name', 'mobile', 'status']));

        return response()->json($familyMember);
    }



    public function destroy(Request $request)
    {
        $missingArguments = [];

        // Check if either 'id' or 'user_id' is provided, not both
        if (!$request->has('id') && !$request->has('user_id')) {
            $missingArguments[] = 'id or user_id';
        }

        // If both are provided, return an error
        if ($request->has('id') && $request->has('user_id')) {
            return response()->json(['message' => 'Please provide only one argument: id or user_id'], 400);
        }

        if (count($missingArguments) > 0) {
            return response()->json([
                'message' => 'Missing arguments',
                'missing_arguments' => $missingArguments
            ], 400);
        }

        // If 'id' is provided, delete the specific family member
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

        // If 'user_id' is provided, delete all family members for that user
        if ($request->has('user_id')) {
            $request->validate([
                'user_id' => 'required|exists:users,id',
            ]);

            $familyMembers = FamilyMemberDetail::where('user_id', $request->user_id)->get();
            if ($familyMembers->isEmpty()) {
                return response()->json(['message' => 'No family members found for this user'], 404);
            }

            // Delete all family members for the specified user
            FamilyMemberDetail::where('user_id', $request->user_id)->delete();

            return response()->json(['message' => 'All family members for the user deleted successfully']);
        }
    }
}
