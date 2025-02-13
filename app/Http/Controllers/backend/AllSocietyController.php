<?php

namespace App\Http\Controllers\Backend;

use MyEvent;
use App\Models\User;
use App\Models\House;
use App\Models\Society;
use Illuminate\Http\Request;
use App\Models\SubscriptionPlan;
use App\Models\SocietySubscription;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AllSocietyController extends Controller
{

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
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = $validator->validated();
        $user = User::create([

            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role_id' => 2,
            'mobile' => $data['mobile'],
            'block' => $data['block'],
            'block_number' => $data['block_number'],
            'profile_photo' => isset($data['profile_photo']) ? $data['profile_photo']->store('profile_photos', 'public') : null,
            'status' => 'active',
        ]);
        $society = Society::create([
            'user_id' => $user->id,
            'society_name' => $data['society_name'],
            'address' => $data['society_address'],
            'city' => $data['society_city'],
            'state' => $data['society_state'],
            'postal_code' => $data['society_pincode'],
            'contact_number' => $data['society_country'],
            'type' => 'residential',
            'status' => 'active',
        ]);
        $user->update(['society_id' => $society->id]);

        foreach ($data['blocks'] as $block) {
            foreach ($block['units'] as $unit) {
                House::create([
                    'house_no' => $unit['unit_title'],
                    'block' => $block['block_title'],
                    'floor' => $unit['floor_no'],
                    'society_id' => $society->id,
                    'user_id' => $user->id,
                    'status' => 'active',
                ]);
            }
        }

        return redirect()->back()->with('success', 'Society, houses, and user registered successfully.');
    }
    public function index()
    {
        session(['heading' => 'All Societies']);
        $societies = Society::with('houses')->get();
        foreach ($societies as $society) {
            $planId = SocietySubscription::where('society_id', $society->id)->first()->plan_id;
            $society->plan = SubscriptionPlan::where('id', $planId)->first()->name;
        }
        return view('societies.index', compact('societies'));
    }
    public function show($id)
    {
        // dd(33);
        // event(new MyEvent('hello world'));
        session(['society_id' => $id]);
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


        // Validate input data
        $request->validate([
            'society_name'   => 'required|string|max:255',
            // 'total_units'    => 'required|integer|min:1',
            // 'total_blocks'   => 'required|integer|min:1',
            'address'        => 'required|string|max:500',
            'city'           => 'required|string|max:255',
            'state'          => 'required|string|max:50',
            'postal_code'    => 'required',
            'contact_number' => 'required', // Adjust as per country
            'type'           => 'required|in:residential,commercial,mixed',
            'status'         => 'required|in:active,inactive',
        ]);
        // dd("hello");

        // Find society record
        $society = Society::findOrFail($id);

        // Update society details
        $society->update([
            'society_name'   => $request->society_name,
            // 'total_units'    => $request->total_units,
            // 'total_blocks'   => $request->total_blocks,
            'address'        => $request->address,
            'city'           => $request->city,
            'state'          => $request->state,
            'postal_code'    => $request->postal_code,
            'contact_number' => $request->contact_number,
            'type'           => $request->type,
            'status'         => $request->status,
        ]);

        // Redirect back with success message
        return redirect()->route('societies.index')->with('success', 'Society updated successfully.');
    }

    public function destroy($id)
    {
        $society = Society::findOrFail($id);
        $society->houses()->delete();
        User::where('society_id', $id)->delete();
        $society->delete();

        return redirect()->back()->with('success', 'Society, houses, and users deleted successfully.');
    }
}
