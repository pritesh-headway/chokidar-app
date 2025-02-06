<?php

namespace App\Http\Controllers;

use App\Models\Amenity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class AmenityController extends Controller
{
    public function index(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'status' => 'nullable|in:active,deactive',
            'title' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation errors.',
                'data' => $validator->errors()
            ], 400);
        }
        $query = Amenity::query();
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('title')) {
            $query->where('title', 'like', "%{$request->title}%");
        }
        $amenities = $query->get();
        if ($amenities->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'No amenities found.',
                'data' => [],
            ], 404);
        }
        $formattedAmenities = $amenities->map(function ($amenity) {

            $amenityImageUrl = $amenity->amenity_image ? url('storage/' . $amenity->amenity_image) : null;
            $amenityImagesUrls = $amenity->amenity_images ? json_decode($amenity->amenity_images, true) : [];
            $amenityImagesUrls = array_map(function ($image) {
                return url('storage/' . $image);
            }, $amenityImagesUrls);

            return [
                'id' => $amenity->id,
                'title' => $amenity->title,
                'amenity_image' => $amenityImageUrl,
                'amenity_images' => $amenityImagesUrls,
                'status' => $amenity->status,
            ];
        });

        return response()->json([
            'status' => true,
            'message' => 'Amenity records retrieved successfully.',
            'data' => $formattedAmenities,
        ], 200);
    }
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'amenity_image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'amenity_images' => 'sometimes|array',
            'amenity_images.*' => 'image',
            'status' => 'sometimes|in:active,deactive',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation errors.',
                'data' => $validator->errors()
            ], 400);
        }

        $imageUrl = $this->storeFileInPublicFolder($request->file('amenity_image'), 'amenity_images');

        $documentPaths = [];
        if ($request->hasFile('amenity_images')) {

            if (is_array($request->file('amenity_images'))) {
                foreach ($request->file('amenity_images') as $document) {

                    $documentPath = $this->storeFileInPublicFolder($document, 'amenity_images');
                    $documentPaths[] = $documentPath;
                }
            } else {

                $documentPath = $this->storeFileInPublicFolder($request->file('amenity_images'), 'amenity_images');
                $documentPaths[] = $documentPath;
            }
        }
        $amenity = Amenity::create([
            'title' => $request->title,
            'amenity_image' => $imageUrl,
            'amenity_images' => json_encode($documentPaths),
            'status' => $request->status ?? "active",
        ]);

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
        $amenity->no = 1;
        $amenityImageUrl = $amenity->amenity_image ? url('storage/' . $amenity->amenity_image) : null;
        $amenityImagesUrls = $amenity->amenity_images ? json_decode($amenity->amenity_images, true) : [];
        $amenityImagesUrls = array_map(function ($image) {
            return url('storage/' . $image);
        }, $amenityImagesUrls);
        $formattedAmenity = [
            'id' => $amenity->id,
            'title' => $amenity->title,
            'amenity_image' => $amenityImageUrl,
            'amenity_images' => $amenityImagesUrls,
            'status' => $amenity->status,
            'no' => $amenity->no,
        ];

        return response()->json([
            'status' => true,
            'message' => 'Amenity fetched successfully.',
            'data' => $formattedAmenity
        ]);
    }
    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:amenities,id',
            'title' => 'sometimes|required|string|max:255',
            'amenity_image' => 'sometimes|image',
            'amenity_images' => 'sometimes|array',
            'amenity_images.*' => 'image',
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
        if ($request->hasFile('amenity_image')) {
            $imageUrl = $this->storeFileInPublicFolder($request->amenity_image, 'amenity_images');
            $amenity->amenity_image = $imageUrl;
        }
        $documentPaths = $amenity->amenity_images ? json_decode($amenity->amenity_images, true) : [];
        if ($request->hasFile('amenity_images')) {

            if (is_array($request->file('amenity_images'))) {
                foreach ($request->file('amenity_images') as $document) {

                    $documentPath = $this->storeFileInPublicFolder($document, 'amenity_images');
                    $documentPaths[] = $documentPath;
                }
            } else {

                $documentPath = $this->storeFileInPublicFolder($request->file('amenity_images'), 'amenity_images');
                $documentPaths[] = $documentPath;
            }
        }
        $amenity->update([
            'title' => $request->title ?? $amenity->title,
            'status' => $request->status ?? $amenity->status,
            'amenity_images' => json_encode($documentPaths),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Amenity updated successfully.',
            'data' => $amenity
        ]);
    }
    public function deleteAmenityImage(Request $request)
    {

        $request->validate([
            'id' => 'required',
            'file_path' => 'required|string',
        ]);
        $id = $request->id;

        $url = $request->file_path;
        $storagePos = strpos($url, 'amenity_images/');
        $filteredUrl = substr($url, $storagePos);
        $amenity = Amenity::find($id);
        if (!$amenity) {
            return response()->json([
                'status' => false,
                'message' => 'Amenity not found'
            ], 404);
        }
        $images = json_decode($amenity->amenity_images, true) ?? [];
        if (!in_array($filteredUrl, $images)) {
            return response()->json([
                'status' => false,
                'message' => 'File not found in amenity_images'
            ], 404);
        }
        $storageFilePath = str_replace("public/storage/", "public/", $filteredUrl);
        if (Storage::exists($storageFilePath)) {
            Storage::delete($storageFilePath);
        }
        $images = array_values(array_diff($images, [$filteredUrl]));
        $amenity->amenity_images = json_encode($images);
        $amenity->save();

        return response()->json([
            'status' => true,
            'message' => 'Image deleted successfully',
            'remaining_images' => $images
        ], 200);
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
        ], 200);
    }
    protected function storeFileInPublicFolder($file, $folder)
    {

        $filename = time() . '_' . preg_replace("/[^A-Za-z0-9\-_\.]/", '_', $file->getClientOriginalName());

        $filename = str_replace(' ', '_', $filename);

        $file->move(public_path("storage/{$folder}"), $filename);
        return "{$folder}/{$filename}";
    }
}
