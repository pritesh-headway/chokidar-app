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
        // Validate the input fields (optional filters)
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

        // Build the query for retrieving the amenity records
        $query = Amenity::query();

        // Apply optional filters
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('title')) {
            $query->where('title', 'like', "%{$request->title}%");
        }

        // Fetch the amenities
        $amenities = $query->get();

        // Check if there are any amenities
        if ($amenities->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'No amenities found.',
                'data' => [],
            ], 404);
        }

        // Format the response
        $formattedAmenities = $amenities->map(function ($amenity) {
            // Get the full URL for the amenity image (single image)
            $amenityImageUrl = $amenity->amenity_image ? url('storage/' . $amenity->amenity_image) : null;

            // Decode and format the amenity images (multiple images)
            $amenityImagesUrls = $amenity->amenity_images ? json_decode($amenity->amenity_images, true) : [];
            $amenityImagesUrls = array_map(function ($image) {
                return url('storage/' . $image);
            }, $amenityImagesUrls);

            return [
                'id' => $amenity->id,
                'title' => $amenity->title,
                'amenity_image' => $amenityImageUrl,
                'amenity_images' => $amenityImagesUrls, // Multiple images
                'status' => $amenity->status,
            ];
        });

        return response()->json([
            'status' => true,
            'message' => 'Amenity records retrieved successfully.',
            'data' => $formattedAmenities,
        ], 200);
    }




    // public function index()
    // {
    //     // Get the logged-in user's society_id
    //     $userSocietyId = auth()->user()->society_id;

    //     // Retrieve amenities filtered by society_id that matches the logged-in user's society_id
    //     $amenities = Amenity::where('society_id', $userSocietyId)->get();

    //     // Base URL for the image
    //     $baseUrl = url('storage/amenity_images');

    //     // Update amenity_image for all amenities and add "no" as a temporary property
    //     $amenities->transform(function ($amenity, $index) use ($baseUrl) {
    //         // Temporarily add the "no" property (index + 1) to the amenity object


    //         // Construct the full URL for amenity_image
    //         $amenity->amenity_image = $baseUrl . '/index.jpg'; // Use index.jpg for amenity_image

    //         // If amenity_images field is a JSON string, update each image URL
    //         $amenity->amenity_images = json_encode(array_map(function ($image) use ($baseUrl) {
    //             return $baseUrl . '/' . basename($image); // Construct the full URL for each image
    //         }, json_decode($amenity->amenity_images, true) ?: []));

    //         return $amenity;
    //     });
    //     $amenities->map(function ($amenity, $index) {
    //         $amenity->no = $index + 1;
    //         return $amenity;
    //     });


    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Amenities fetched successfully.',
    //         'data' => $amenities
    //     ]);
    // }



    // public function store(Request $request)
    // {
    //     // Validate the input fields, including image file uploads
    //     $validator = Validator::make($request->all(), [
    //         'title' => 'required|string|max:255',
    //         'amenity_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate the single amenity image
    //         'amenity_images' => 'required|array', // Validate that amenity_images is an array
    //         'amenity_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validate that each file in amenity_images is an image
    //         'status' => 'required|in:active,deactive',
    //     ]);

    //     // If validation fails, return the errors
    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Validation errors.',
    //             'data' => $validator->errors()
    //         ], 400);
    //     }

    //     // Handle the single amenity image upload
    //     if ($request->hasFile('amenity_image')) {
    //         $amenityImage = $request->file('amenity_image');

    //         // Store the image in the public storage disk under 'amenity_images'
    //         $imagePath = $amenityImage->store('amenity_images', 'public');

    //         // Get the URL of the uploaded image
    //         $imageUrl = url('storage/' . $imagePath);
    //     } else {
    //         $imageUrl = null; // If no image is uploaded, set to null or handle accordingly
    //     }

    //     // Handle the multiple amenity images upload
    //     $amenityImagesUrls = [];
    //     if ($request->hasFile('amenity_images')) {
    //         foreach ($request->file('amenity_images') as $file) {
    //             // Store each file in the public storage disk under 'amenity_images'
    //             $imagePath = $file->store('amenity_images', 'public');

    //             // Get the URL for each uploaded image
    //             $amenityImagesUrls[] = url('storage/' . $imagePath);
    //         }
    //     }

    //     // Create the amenity record and associate the uploaded images
    //     $amenity = Amenity::create([
    //         'title' => $request->title,
    //         'amenity_image' => $imageUrl, // Save the URL for the single amenity image
    //         'amenity_images' => json_encode($amenityImagesUrls), // Store the URLs of multiple amenity images as a JSON array
    //         'status' => $request->status,
    //     ]);

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Amenity created successfully.',
    //         'data' => $amenity
    //     ], 201);
    // }



    // public function show(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'id' => 'required|integer|exists:amenities,id',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Validation errors.',
    //             'data' => $validator->errors()
    //         ], 400);
    //     }

    //     $amenity = Amenity::find($request->id);
    //     $amenity->amenity_image = url('storage/amenity_images/index.jpg'); // Set the amenity image URL

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Amenity fetched successfully.',
    //         'data' => $amenity
    //     ]);
    // }


    public function store(Request $request)
    {
        // Validate the input fields, including image file uploads
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'amenity_image' => 'required|image|mimes:jpeg,png,jpg,gif', // Validate the single amenity image
            'amenity_images' => 'required|array', // Validate that amenity_images is an array
            'amenity_images.*' => 'image', // Validate that each file in amenity_images is an image
            'status' => 'sometimes|in:active,deactive',
        ]);

        // If validation fails, return the errors
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation errors.',
                'data' => $validator->errors()
            ], 400);
        }
        // dd($request->file('amenity_images'));
        $imageUrl = $this->storeFileInPublicFolder($request->file('amenity_image'), 'amenity_images');

        $documentPaths = [];
        if ($request->hasFile('amenity_images')) {
            // If it's multiple files
            if (is_array($request->file('amenity_images'))) {
                foreach ($request->file('amenity_images') as $document) {
                    // Store each document and get the path
                    $documentPath = $this->storeFileInPublicFolder($document, 'amenity_images');
                    $documentPaths[] = $documentPath;
                }
            } else {
                // If it's a single file
                $documentPath = $this->storeFileInPublicFolder($request->file('amenity_images'), 'amenity_images');
                $documentPaths[] = $documentPath;
            }
        }


        // Create the amenity record and associate the uploaded images
        $amenity = Amenity::create([
            'title' => $request->title,
            'amenity_image' => $imageUrl, // Save the URL for the single amenity image
            'amenity_images' => json_encode($documentPaths), // Store the URLs of multiple amenity images as a JSON array
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
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:amenities,id',
        ]);

        // Return validation errors if validation fails
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation errors.',
                'data' => $validator->errors()
            ], 400);
        }

        // Fetch the amenity by ID
        $amenity = Amenity::find($request->id);

        // Add a temporary "no" property (for consistency with index method)
        $amenity->no = 1;

        // Get the full URL for the amenity image (single image)
        $amenityImageUrl = $amenity->amenity_image ? url('storage/' . $amenity->amenity_image) : null;

        // Decode and format the amenity images (multiple images)
        $amenityImagesUrls = $amenity->amenity_images ? json_decode($amenity->amenity_images, true) : [];
        $amenityImagesUrls = array_map(function ($image) {
            return url('storage/' . $image);
        }, $amenityImagesUrls);

        // Format the amenity data
        $formattedAmenity = [
            'id' => $amenity->id,
            'title' => $amenity->title,
            'amenity_image' => $amenityImageUrl, // Single amenity image
            'amenity_images' => $amenityImagesUrls, // Multiple amenity images
            'status' => $amenity->status,
            'no' => $amenity->no, // Add the "no" property
        ];

        return response()->json([
            'status' => true,
            'message' => 'Amenity fetched successfully.',
            'data' => $formattedAmenity
        ]);
    }



    public function update(Request $request)
    {
        // Validate the input fields, including image file uploads
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:amenities,id',
            'title' => 'sometimes|required|string|max:255',
            'amenity_image' => 'sometimes|image', // Validate the single amenity image
            'amenity_images' => 'sometimes|array', // Validate that amenity_images is an array
            'amenity_images.*' => 'image', // Validate that each file in amenity_images is an image
            'status' => 'sometimes|required|in:active,deactive',
        ]);
        // dd($request->file('amenity_images'));

        // If validation fails, return the errors
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation errors.',
                'data' => $validator->errors()
            ], 400);
        }

        // Find the amenity record by ID
        $amenity = Amenity::find($request->id);

        // Handle the amenity_image update (if a new image is provided)
        if ($request->hasFile('amenity_image')) {
            // $filePath = urldecode($request->amenity_image);
            // dd($filePath);
            // Store the new amenity image and get the file path
            $imageUrl = $this->storeFileInPublicFolder($request->amenity_image, 'amenity_images');
            $amenity->amenity_image = $imageUrl; // Update the amenity image URL
        }

        // Handle the amenity_images update (if new images are provided)
        $documentPaths = $amenity->amenity_images ? json_decode($amenity->amenity_images, true) : [];
        if ($request->hasFile('amenity_images')) {
            // If it's multiple files
            if (is_array($request->file('amenity_images'))) {
                foreach ($request->file('amenity_images') as $document) {
                    // Store each document and get the path
                    $documentPath = $this->storeFileInPublicFolder($document, 'amenity_images');
                    $documentPaths[] = $documentPath;
                }
            } else {
                // If it's a single file
                $documentPath = $this->storeFileInPublicFolder($request->file('amenity_images'), 'amenity_images');
                $documentPaths[] = $documentPath;
            }
        }

        // Update the amenity record with the new data
        $amenity->update([
            'title' => $request->title ?? $amenity->title, // Only update if provided
            'status' => $request->status ?? $amenity->status, // Only update if provided
            'amenity_images' => json_encode($documentPaths), // Update the amenity_images
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Amenity updated successfully.',
            'data' => $amenity
        ]);
    }



    public function deleteAmenityImage(Request $request)
    {
        // Validate request
        $request->validate([
            'id' => 'required',
            'file_path' => 'required|string', // The exact file path to delete
        ]);
        $id = $request->id;

        // Find the amenity record
        $amenity = Amenity::find($id);
        if (!$amenity) {
            return response()->json([
                'status' => false,
                'message' => 'Amenity not found'
            ], 404);
        }

        // Decode amenity_images field (assuming it's stored as JSON)
        $images = json_decode($amenity->amenity_images, true) ?? [];

        // Check if the file exists in the images list
        if (!in_array($request->file_path, $images)) {
            return response()->json([
                'status' => false,
                'message' => 'File not found in amenity_images'
            ], 404);
        }

        // Convert file path for storage deletion
        $storageFilePath = str_replace("public/storage/", "public/", $request->file_path);

        // Delete the file from storage
        if (Storage::exists($storageFilePath)) {
            Storage::delete($storageFilePath);
        }

        // Remove the deleted file from the array
        $images = array_values(array_diff($images, [$request->file_path]));

        // Update the record with the modified amenity_images array
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
        ], 200); // Use 200 OK to allow response body
    }


    protected function storeFileInPublicFolder($file, $folder)
    {
        // Generate a unique file name
        $filename = time() . '_' . preg_replace("/[^A-Za-z0-9\-_\.]/", '_', $file->getClientOriginalName());
        // dd($filename);
        $filename = str_replace(' ', '_', $filename);
        // Move the file to the desired folder in public/storage
        $file->move(public_path("storage/{$folder}"), $filename);

        // Return the relative path to the file
        return "{$folder}/{$filename}";
    }
}