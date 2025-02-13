<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;

class SubscriptionPlanController extends Controller
{
    public function index()
    {
        $plans = SubscriptionPlan::all();
        return view('subscription_plans.index', compact('plans'));
    }

    public function create()
    {
        return view('subscription_plans.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'duration' => 'required|integer',
            'status' => 'required|in:active,inactive',
        ]);

        SubscriptionPlan::create($validated);
        return redirect()->route('subscription_plans.index');
    }

    public function show($id)
    {
        $plan = SubscriptionPlan::findOrFail($id);
        return view('subscription_plans.show', compact('plan'));
    }

    public function edit($id)
    {
        $plan = SubscriptionPlan::findOrFail($id);
        return view('subscription_plans.edit', compact('plan'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'price' => 'sometimes|required|numeric',
            'duration' => 'sometimes|required|integer',
            'status' => 'sometimes|required|in:active,inactive',
        ]);

        $plan = SubscriptionPlan::findOrFail($id);
        $plan->update($validated);
        return redirect()->route('subscription_plans.index');
    }

    public function destroy($id)
    {
        $plan = SubscriptionPlan::findOrFail($id);
        $plan->delete();
        return redirect()->route('subscription_plans.index');
    }
}
