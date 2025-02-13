<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\SocietySubscription;
use Illuminate\Support\Facades\Validator;

class SocietySubscriptionController extends Controller
{
    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'society_id' => 'required|exists:societies,id',
            'plan_id' => 'required|exists:subscription_plans,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => ['required', Rule::in(['active', 'expired', 'cancelled'])],
        ]);

        $subscription = SocietySubscription::create($validated);

        return response()->json([
            'status' => true,
            'message' => 'Subscription created successfully',
            'data' => $subscription
        ]);
    }

    public function update(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'id' => 'required|exists:society_subscriptions,id',
            'society_id' => 'sometimes|exists:societies,id',
            'plan_id' => 'sometimes|exists:subscription_plans,id',
            'start_date' => 'sometimes|date',
            'end_date' => 'sometimes|date|after:start_date',
            'status' => ['sometimes', Rule::in(['active', 'expired', 'cancelled'])],
        ]);

        $subscription = SocietySubscription::findOrFail($request->id);
        $subscription->update($validated);

        return response()->json([
            'status' => true,
            'message' => 'Subscription updated successfully',
            'data' => $subscription
        ]);
    }

    public function destroy(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'id' => 'required|exists:society_subscriptions,id',
        ]);

        SocietySubscription::destroy($validated['id']);

        return response()->json([
            'status' => true,
            'message' => 'Subscription deleted successfully'
        ]);
    }

    public function show(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'id' => 'required|exists:society_subscriptions,id',
        ]);

        $subscription = SocietySubscription::with(['society', 'plan'])->findOrFail($validated['id']);

        return response()->json([
            'status' => true,
            'message' => 'Subscription retrieved successfully',
            'data' => $subscription
        ]);
    }

    public function list(Request $request)
    {
        $subscriptions = SocietySubscription::with(['society', 'plan'])->get();

        return response()->json([
            'status' => true,
            'message' => 'Subscriptions retrieved successfully',
            'data' => $subscriptions
        ]);
    }
}
