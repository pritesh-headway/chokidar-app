<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubscriptionPlan;
use Illuminate\Support\Facades\Validator;

class SubscriptionPlanController extends Controller
{
    public function index()
    {
        // dd(auth()->user()->role_id);
        return SubscriptionPlan::all();
    }

    // public function store(Request $request)
    // {
    //     dd($request->all());
    //     $validated = Validator::make($request->all(), [
    //         'name' => 'required|string|max:255',
    //         'price' => 'required|numeric',
    //         'duration' => 'required|integer',
    //         'status' => 'sometimes|in:active,inactive',
    //     ]);

    //     return SubscriptionPlan::create($validated);
    // }

    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'duration' => 'required|integer',
            'status' => 'sometimes|in:active,inactive',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation errors',
                'errors' => $validated->errors(),
            ], 422);
        }

        // Get validated data and set default status if not provided
        $data = $validated->validated();
        $data['status'] = $data['status'] ?? 'active';

        $subscription = SubscriptionPlan::create($data);

        return response()->json([
            'status' => true,
            'message' => 'Subscription plan created successfully',
            'data' => $subscription
        ], 201);
    }


    public function show(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:subscription_plans,id',
        ]);

        return SubscriptionPlan::find($validated['id']);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:subscription_plans,id',
            'name' => 'sometimes|required|string|max:255',
            'price' => 'sometimes|required|numeric',
            'duration' => 'sometimes|required|integer',
            'status' => 'sometimes|required|in:active,inactive',
        ]);

        $subscriptionPlan = SubscriptionPlan::find($validated['id']);
        $subscriptionPlan->update($validated);

        return $subscriptionPlan;
    }

    public function destroy(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:subscription_plans,id',
        ]);

        $subscriptionPlan = SubscriptionPlan::find($validated['id']);
        $subscriptionPlan->delete();

        return response()->json(['message' => 'Subscription Plan deleted successfully']);
    }
}
