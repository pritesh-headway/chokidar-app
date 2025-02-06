<?php

namespace App\Http\Controllers;

use App\Models\UserRole;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

class UserRoleController extends Controller
{

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'role_id' => 'required|exists:roles,id',
        ]);

        $userRole = UserRole::create([
            'user_id' => $request->user_id,
            'role_id' => $request->role_id,
        ]);

        return response()->json(['message' => 'Role assigned successfully.', 'data' => $userRole], 201);
    }
    public function destroy(Request $request, $id)
    {
        $userRole = UserRole::findOrFail($id);

        $userRole->delete();

        return response()->json(['message' => 'User role deleted successfully.']);
    }
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'role_id' => 'required|exists:roles,id',
        ]);

        $userRole = UserRole::findOrFail($id);

        $userRole->update([
            'role_id' => $request->role_id,
        ]);

        return response()->json(['message' => 'User role updated successfully.', 'data' => $userRole]);
    }
}
