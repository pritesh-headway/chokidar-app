<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use App\Models\House;
use App\Models\Society;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AllSocietyController extends Controller
{
    // Create a new society
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'society_name' => 'required|string|max:255',
            'society_address' => 'required|string|max:255',
            'society_city' => 'required|string|max:255',
            'society_state' => 'required|string|max:255',
            'society_country' => 'required|string|max:255',
            'society_pincode' => 'required|string|max:10',
            'total_blocks' => 'required|integer',
            'blocks' => 'required|array',
            'blocks.*.block_title' => 'required|string|max:255',
            'blocks.*.units.*.unit_title' => 'required|string|max:255',
            'blocks.*.units' => 'required|array',
            'blocks.*.units.*.floor_no' => 'required|integer',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'mobile' => 'required|string|max:15',
            'block' => 'required|string|max:255',
            'block_number' => 'required|string|max:255',
            'profile_photo' => 'nullable|image',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string',
        ]);
        // if ($validator->fails()) {
        //     return redirect()->back()->withErrors($validator)->withInput();
        // }
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = $validator->validated();

        // Create a user row for the society
        $user = User::create([
            // 'name' => $data['first_name'] . ' ' . $data['last_name'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role_id' => 2, // Default role_id
            'mobile' => $data['mobile'],
            'block' => $data['block'],
            'block_number' => $data['block_number'],
            'profile_photo' => isset($data['profile_photo']) ? $data['profile_photo']->store('profile_photos', 'public') : null,
            'status' => 'active', // Default status
        ]);

        // Create a new society with the user_id from the newly created user
        $society = Society::create([
            'user_id' => $user->id,
            'society_name' => $data['society_name'],
            'address' => $data['society_address'],
            'city' => $data['society_city'],
            'state' => $data['society_state'],
            'postal_code' => $data['society_pincode'],
            'contact_number' => $data['society_country'],
            'type' => 'residential', // Assuming type is residential
            'status' => 'active', // Assuming status is active
        ]);

        // Update the user's society_id to the newly created society's id
        $user->update(['society_id' => $society->id]);

        foreach ($data['blocks'] as $block) {
            foreach ($block['units'] as $unit) {
                House::create([
                    'house_no' => $unit['unit_title'],
                    'block' => $block['block_title'],
                    'floor' => $unit['floor_no'],
                    'society_id' => $society->id,
                    'user_id' => $user->id,
                    'status' => 'active', // Assuming status is active
                ]);
            }
        }

        return redirect()->back()->with('success', 'Society, houses, and user registered successfully.');
    }

    // Get a list of all societies
    public function index()
    {
        $societies = Society::with('houses')->get();
        return view('societies.index', compact('societies'));
    }

    // Get a specific society by ID
    public function show($id)
    {
        $society = Society::with('houses')->findOrFail($id);
        return view('societies.show', compact('society'));
    }

    public function edit($id)
    {
        $society = Society::with('houses')->findOrFail($id);
        return view('societies.edit', compact('society'));
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'society_name' => 'required|string|max:255',
            'society_address' => 'required|string|max:255',
            'society_city' => 'required|string|max:255',
            'society_state' => 'required|string|max:255',
            'society_country' => 'required|string|max:255',
            'society_pincode' => 'required|string|max:10',
        ]);

        $society = Society::findOrFail($id);
        $society->update([
            'society_name' => $request->society_name,
            'address' => $request->society_address,
            'city' => $request->society_city,
            'state' => $request->society_state,
            'postal_code' => $request->society_pincode,
            'contact_number' => $request->society_country,
        ]);

        return redirect()->back()->with('success', 'Society updated successfully.');
    }

    // Delete a society by ID
    public function destroy($id)
    {
        $society = Society::findOrFail($id);

        // Delete all houses associated with the society
        $society->houses()->delete();

        // Delete all users associated with the society
        User::where('society_id', $id)->delete();

        // Delete the society
        $society->delete();

        return redirect()->back()->with('success', 'Society, houses, and users deleted successfully.');
    }
}
