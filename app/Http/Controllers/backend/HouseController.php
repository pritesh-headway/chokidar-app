<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\House;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class HouseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     $houses = House::all();
    //     return view('houses.index', compact('houses'));
    // }
    /**
     * Display a listing of the resource for the current society.
     */
    public function index(Request $request)
    {
        // dd($request->society_id);
        // dd((int)substr(url()->previous(), -1));
        // logger((int)substr(url()->previous(), -1));
        // dd((int)substr(url()->previous(), -1));
        // dd($request->headers->get('referer'));

        // $societyId = (int)substr($request->session()->previousUrl(), -1);
        // Log::info(url()->previous());
        $societyId = session('society_id');
        $houses = House::where('society_id', $societyId)->get();
        return view('houses.index', compact('houses'));
    }

    // public function index($society_id = null)
    // {
    //     session('society_id');
    //     dd(session('society_id'));
    //     if ($society_id) {
    //         session(['society_id' => $society_id]); // Store society_id in session
    //     } else {
    //         $society_id = session('society_id'); // Retrieve from session
    //     }

    //     if (!$society_id) {
    //         return redirect()->route('societies.index')->with('error', 'Society ID is required.');
    //     }

    //     $houses = House::where('society_id', $society_id)->get();
    //     return view('houses.index', compact('houses'));
    // }




    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(House $house)
    {
        return view('houses.show', compact('house'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(House $house)
    {
        return view('houses.edit', compact('house'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, House $house)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(House $house)
    {
        $house->delete();
        return redirect()->route('houses.index')->with('success', 'House deleted successfully');
    }
}
