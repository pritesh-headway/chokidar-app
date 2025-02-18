<?php

namespace App\Http\Controllers;

use App\Models\House;
use Illuminate\Http\Request;

class HouseController extends Controller
{

    public function index()
    {
        // dd(auth()->user());
        $houses = House::where('society_id', auth()->user()->society_id)->get();
        return response()->json([
            'status' => true,
            'message' => 'Houses retrieved successfully',
            'data' => $houses
        ]);
    }

    public function create()
    {
        // Not needed for API
    }

    public function store(Request $request)
    {
        $request->validate([
            'house_no' => 'required',
            'block' => 'required',
            'floor' => 'required',
            'society_id' => 'required',
            'user_id' => 'required',
            'status' => 'required',
        ]);

        $house = House::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'House created successfully',
            'data' => $house
        ]);
    }

    public function show(Request $request)
    {
        $query = House::query();


        $query->where('society_id', auth()->user()->society_id);
        if ($request->has('id')) {
            $query->where('id', $request->id);
        }

        if ($request->has('block')) {
            $query->where('block', $request->block);
        }
        // dd($query->where('block', $request->block));

        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->has('house_no')) {
            $query->where('house_no', $request->house_no);
        }
        $houses = $query->get();

        if ($houses->isEmpty()) {
            return response()->json(['message' => 'Houses not found'], 404);
        }



        return response()->json([
            'status' => true,
            'message' => 'Houses retrieved successfully',
            'data' => $houses
        ]);
    }

    public function edit(House $house)
    {
        // Not needed for API
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:houses,id',
            'house_no' => 'sometimes|required',
            'block' => 'sometimes|required',
            'floor' => 'sometimes|required',
            'society_id' => 'sometimes|required',
            'user_id' => 'sometimes|required',
            'status' => 'sometimes|required',
        ]);

        $house = House::findOrFail($request->id);

        $house->update($request->only([
            'house_no',
            'block',
            'floor',
            'society_id',
            'user_id',
            'status'
        ]));

        return response()->json([
            'status' => true,
            'message' => 'House updated successfully',
            'data' => $house
        ]);
    }
    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:houses,id',
        ]);

        $house = House::findOrFail($request->id);
        $house->delete();

        return response()->json(['status' => true, 'message' => 'House deleted successfully'], 200);
    }
}
