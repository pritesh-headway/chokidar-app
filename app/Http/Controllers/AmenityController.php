<?php

namespace App\Http\Controllers;

use App\Models\Amenity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AmenityController extends Controller
{
    public function index(Request $request)
    {
        $amenities = Amenity::all();

        // Base URL for the image
        $baseUrl = url('storage/amenity_images');

        // Update amenity_image for all amenities
        $amenities->transform(function ($amenity) use ($baseUrl) {
            // Construct the full URL for amenity_image
            $amenity->amenity_image = $baseUrl . '/index.jpg'; // Use index.jpg for amenity_image
            // If amenity_images field is a JSON string, update each image URL
            $amenity->amenity_images = json_encode(array_map(function ($image) use ($baseUrl) {
                return $baseUrl . '/' . basename($image); // Construct the full URL for each image
            }, json_decode($amenity->amenity_images, true) ?: []));

            return $amenity;
        });

        return response()->json([
            'status' => true,
            'message' => 'Amenities fetched successfully.',
            'data' => $amenities
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'amenity_image' => 'required|string|max:256',
            'amenity_images' => 'required|string', // Assuming it's a JSON string or comma-separated values
            'status' => 'required|in:active,deactive',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation errors.',
                'data' => $validator->errors()
            ], 400);
        }

        $amenity = Amenity::create($request->all());
        $amenity->amenity_image = url('storage/amenity_images/index.jpg'); // Set the amenity image URL

        return response()->json([
            'status' => true,
            'message' => 'Amenity created successfully.',
            'data' => $amenity
        ], 201);
    }

    public function show(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:amenities,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation errors.',
                'data' => $validator->errors()
            ], 400);
        }

        $amenity = Amenity::find($request->id);
        $amenity->amenity_image = url('storage/amenity_images/index.jpg'); // Set the amenity image URL

        return response()->json([
            'status' => true,
            'message' => 'Amenity fetched successfully.',
            'data' => $amenity
        ]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:amenities,id',
            'title' => 'sometimes|required|string|max:255',
            'amenity_image' => 'sometimes|required|string|max:256',
            'amenity_images' => 'sometimes|required|string',
            'status' => 'sometimes|required|in:active,deactive',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation errors.',
                'data' => $validator->errors()
            ], 400);
        }

        $amenity = Amenity::find($request->id);
        $amenity->update($request->all());
        $amenity->amenity_image = url('storage/amenity_images/index.jpg'); // Set the amenity image URL

        return response()->json([
            'status' => true,
            'message' => 'Amenity updated successfully.',
            'data' => $amenity
        ]);
    }

    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:amenities,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation errors.',
                'data' => $validator->errors()
            ], 400);
        }

        $amenity = Amenity::find($request->id);
        $amenity->delete();

        return response()->json([
            'status' => true,
            'message' => 'Amenity deleted successfully.',
            'data' => null
        ], 200); // Use 200 OK to allow response body
    }
}
