<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Security;
use App\Models\UserRole;
use App\Models\GateDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SecurityController extends Controller
{

    public function store(Request $request)
    {
        // Validate the request
        $validatedData = $request->validate([
            'guard_name' => 'required|string|max:50',
            'mobile' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'gate_no' => 'required|integer',
            'details' => 'required|string',
            'guard_image' => 'required|string|max:256',
            'documents' => 'required|array',
            'status' => 'nullable|in:active,deactive',
        ]);

        // Default to 'deactive' status if not provided
        $status = $request->get('status', 'deactive');

        // Create the security record
        $security = Security::create([
            'guard_name' => $request->guard_name,
            'mobile' => $request->mobile,
            'address' => $request->address,
            'gate_no' => $request->gate_no,
            'details' => $request->details,
            'guard_image' => $request->guard_image,
            'documents' => json_encode($request->documents),
            'status' => $status,
        ]);


        return response()->json(['message' => 'Security record created successfully.', 'data' => $security], 201);
    }


    public function show(Request $request)
    {
        // dd($request);
        // Validate input (optional filters)
        $validatedData = $request->validate([
            'id' => 'nullable|exists:securities,id',
            'guard_name' => 'nullable|string',
            'mobile' => 'nullable|string',
            'gate_no' => 'nullable|string',
            'status' => 'nullable|in:active,deactive',
        ]);

        // Get the logged-in user's society_id
        $loggedInUser = auth()->user();
        $loggedInSocietyId = $loggedInUser->society_id;

        // Query to fetch security records
        $query = Security::where('society_id', $loggedInSocietyId);

        // Apply optional filters
        if (!empty($validatedData['id'])) {
            $query->where('id', $validatedData['id']);
        }
        if (!empty($validatedData['guard_name'])) {
            $query->where('guard_name', 'like', "%{$validatedData['guard_name']}%");
        }
        if (!empty($validatedData['mobile'])) {
            $query->where('mobile', $validatedData['mobile']);
        }
        if (!empty($validatedData['gate_no'])) {
            $query->where('gate_no', $validatedData['gate_no']);
        }
        if (!empty($validatedData['status'])) {
            $query->where('status', $validatedData['status']);
        }

        // Fetch security records
        $securities = $query->get();

        // Check if records exist
        if ($securities->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'No security guards found.',
                'data' => [],
            ], 404);
        }

        // Format the response
        $securityData = $securities->map(function ($security) {
            return [
                'id' => $security->id,
                'guard_name' => $security->guard_name,
                'user_id' => $security->user_id,
                'mobile' => $security->mobile,
                'address' => $security->address,
                'gate_no' => $security->gate_no,
                'details' => $security->details,
                'guard_image' => $this->getFullUrl($security->guard_image),
                // 'documents' => $this->getFullUrls(json_decode($security->documents, true)), // Decode JSON for array output
                'documents' => $this->getFullUrls($security->documents),
                'status' => $security->status,
                'society_id' => $security->society_id,
            ];
        });

        return response()->json([
            'status' => true,
            'message' => 'Security records retrieved successfully.',
            'data' => $securityData,
        ], 200);
    }


    // public function update(Request $request)
    // {
    //     // Custom validation messages
    //     $messages = [
    //         'id.required' => 'Security ID is required.',
    //         'id.exists' => 'Invalid security ID.',
    //         'guard_name.max' => 'Guard name must not exceed 50 characters.',
    //         'mobile.max' => 'Mobile number must not exceed 20 characters.',
    //         'address.max' => 'Address must not exceed 255 characters.',
    //         'gate_no.integer' => 'Gate number must be an integer.',
    //         'guard_image.max' => 'Guard image path must not exceed 256 characters.',
    //         'status.in' => 'Invalid status value.',
    //     ];

    //     // Validate input
    //     $validator = Validator::make($request->all(), [
    //         'id' => 'required|integer|exists:securities,id',
    //         'guard_name' => 'nullable|string|max:50',
    //         'mobile' => 'nullable|string|max:20',
    //         'address' => 'nullable|string|max:255',
    //         'gate_no' => 'nullable|integer',
    //         'details' => 'nullable|string',
    //         'guard_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB max
    //         'documents' => 'nullable|array',
    //         'documents.*' => 'file|mimes:pdf,doc,docx|max:5120', // 5MB max per file
    //         'status' => 'nullable|in:active,deactive',
    //     ], $messages);

    //     // Return errors if validation fails
    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Validation errors',
    //             'errors' => $validator->errors()
    //         ], 422);
    //     }

    //     // Find the security record
    //     $security = Security::findOrFail($request->id);

    //     // Update the security guard's details
    //     $security->guard_name = $request->guard_name ?? $security->guard_name;
    //     $security->mobile = $request->mobile ?? $security->mobile;
    //     $security->address = $request->address ?? $security->address;
    //     $security->gate_no = $request->gate_no ?? $security->gate_no;
    //     $security->details = $request->details ?? $security->details;
    //     $security->status = $request->status ?? $security->status;

    //     // Handle guard image update
    //     if ($request->hasFile('guard_image')) {
    //         // Delete the old guard image if it exists
    //         if ($security->guard_image && file_exists(public_path($security->guard_image))) {
    //             unlink(public_path($security->guard_image));
    //         }

    //         // Store the new guard image
    //         $guardImagePath = $this->storeFileInPublicFolder($request->file('guard_image'), 'guard_images');
    //         $security->guard_image = $guardImagePath;
    //     }

    //     // Handle documents update
    //     if ($request->hasFile('documents')) {
    //         // Delete the old documents if they exist
    //         if ($security->documents) {
    //             $oldDocuments = json_decode($security->documents, true);
    //             foreach ($oldDocuments as $oldDocument) {
    //                 if (file_exists(public_path($oldDocument))) {
    //                     unlink(public_path($oldDocument));
    //                 }
    //             }
    //         }

    //         // Store the new documents
    //         $documentPaths = [];
    //         foreach ($request->file('documents') as $document) {
    //             $fileName = $document->getClientOriginalName();
    //             $document->move(public_path('storage/guard_documents'), $fileName);
    //             $documentPaths[] = 'guard_documents/' . $fileName;
    //         }
    //         $security->documents = json_encode($documentPaths);
    //     }

    //     // Save the updated security record
    //     $security->save();

    //     // Update related user record (if mobile or status is updated)
    //     $user = User::find($security->user_id);
    //     if ($user) {
    //         $user->mobile = $request->mobile ?? $user->mobile;
    //         $user->status = $request->status ?? $user->status;
    //         $user->save();
    //     }

    //     // Update related gate_details record
    //     $gateDetail = GateDetail::where('security_id', $security->id)->first();
    //     if ($gateDetail) {
    //         $gateDetail->gate_no = $request->gate_no ?? $gateDetail->gate_no;
    //         $gateDetail->gate_mobile = $request->mobile ?? $gateDetail->gate_mobile;
    //         $gateDetail->status = $request->status ?? $gateDetail->status;
    //         $gateDetail->save();
    //     }

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Security guard updated successfully',
    //         'data' => $security
    //     ], 200);
    // }

    public function update(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:securities,id',
            'first_name' => 'nullable|string|max:50',
            'last_name' => 'nullable|string|max:50',
            'mobile' => 'nullable|string|max:20',
            'gate_no' => 'nullable|integer',
            'address' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Fetch the security record
        $security = Security::findOrFail($request->id);
        $user = User::findOrFail($security->user_id);
        $gateDetail = GateDetail::where('security_id', $security->id)->first();

        // Validate mobile only if it's changed
        if ($request->filled('mobile') && $request->mobile !== $user->mobile) {
            $mobileExists = User::where('mobile', $request->mobile)->where('id', '!=', $user->id)->exists();
            if ($mobileExists) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation errors',
                    'errors' => ['mobile' => ['This mobile number is already registered.']],
                ], 422);
            }
        }

        // Start Transaction to ensure all updates succeed together
        DB::beginTransaction();
        try {
            // Prepare updated values
            $updateData = [];
            if ($request->filled('first_name') || $request->filled('last_name')) {
                $guard_name = trim(($request->first_name ?? $user->first_name) . ' ' . ($request->last_name ?? $user->last_name));
                $updateData['guard_name'] = $guard_name;
            }
            if ($request->filled('gate_no')) {
                $updateData['gate_no'] = $request->gate_no;
            }
            if ($request->filled('address')) {
                $updateData['address'] = $request->address;
            }
            if ($request->filled('mobile')) {
                $updateData['mobile'] = $request->mobile;
            }

            // Update only changed fields in Security table
            $security->update($updateData);

            // Update only changed fields in User table
            $user->update($request->only(['first_name', 'last_name', 'mobile']));

            // Update only changed fields in GateDetails table (if exists)
            if ($gateDetail) {
                $gateDetail->update([
                    'gate_no' => $request->gate_no ?? $gateDetail->gate_no,
                    // 'gate_mobile' => $request->mobile ?? $gateDetail->gate_mobile
                ]);
            }

            DB::commit(); // Commit transaction
            $data = $security;
            $data->gate_mobile = $gateDetail->gate_mobile;

            return response()->json([
                'status' => true,
                'message' => 'Security guard updated successfully',
                'data' => $data,
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback on error
            return response()->json([
                'status' => false,
                'message' => 'Update failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }




    // Destroy a specific security record
    public function destroy(Request $request)
    {
        // Validate the incoming request to ensure 'id' exists in the securities table
        $validatedData = $request->validate([
            'id' => 'required|integer|exists:securities,id',
        ]);

        // Retrieve the security guard record
        $security = Security::findOrFail($request->id);
        $userId = $security->user_id; // Store user_id temporarily
        $securityId = $security->id; // Store security_id temporarily

        // Delete the security guard entry from the 'securities' table
        $security->delete();

        // Delete the corresponding gate detail entry using security_id
        GateDetail::where('security_id', $securityId)->delete();

        // Delete the corresponding user role entry using user_id
        UserRole::where('user_id', $userId)->delete();

        // Delete the user entry from the 'users' table using user_id
        User::where('id', $userId)->delete();

        return response()->json(['status' => true, 'message' => 'Security and associated records deleted successfully.']);
    }


    public function index(Request $request)
    {
        // Get the logged-in user's society_id
        $loggedInUser = auth()->user();
        $loggedInSocietyId = $loggedInUser->society_id;

        // Fetch securities that belong to the logged-in user's society_id
        $securities = Security::where('society_id', $loggedInSocietyId)
            ->get(); // No need for whereHas('gateDetails') anymore

        // Format the response
        $securitiesWithDetails = $securities->map(function ($security, $index) use ($loggedInSocietyId) {
            // Fetch gate details using society_id and gate_no
            $gateDetail = GateDetail::where('society_id', $loggedInSocietyId)
                ->where('gate_no', $security->gate_no)
                ->first();

            // Get the gate_mobile if found
            $gateMobile = $gateDetail ? $gateDetail->gate_mobile : null;

            return [
                'id' => $security->id,
                'no' => $index + 1,
                'user_id' => $security->user_id,
                'guard_name' => $security->guard_name,
                'personal_mobile' => $security->mobile,
                'address' => $security->address,
                'gate_no' => $security->gate_no,
                'gate_contact_no' => $gateMobile,
                'details' => $security->details,
                'guard_image' => $this->getFullUrl($security->guard_image),
                'documents' => $this->getFullUrls($security->documents),
                'status' => $security->status,
            ];
        });

        return response()->json([
            'status' => true,
            'message' => 'Securities retrieved successfully.',
            'data' => $securitiesWithDetails,
        ]);
    }





    // Helper function to get full URLs for multiple documents
    protected function getFullUrls($documents)
    {
        // Decode the JSON string into an array
        $documentsArray = json_decode($documents, true);

        // Check if decoding was successful and is an array
        if (is_array($documentsArray)) {
            return collect($documentsArray)->map(function ($doc) {
                return $this->getFullUrl($doc);
                // return  env('APP_URL') . '/public/storage/' . $doc;
            })->toArray();
        }

        // Return an empty array if decoding fails or it's not an array
        return [];
    }

    // Helper function to get the full URL of a single image or document
    protected function getFullUrl($path)
    {
        // dd(env('APP_URL'));
        return config('app.url') . '/public/storage/' . $path;
    }



    public function registerSecurity(Request $request)
    {
        // Custom validation messages
        $messages = [
            'first_name.required' => 'First name is required.',
            'last_name.required' => 'Last name is required.',
            'mobile.required' => 'Mobile number is required.',
            'mobile.unique' => 'This mobile number is already registered.',
            'otp.required' => 'OTP is required.',
            'gate_no.required' => 'Gate number is required.',
            'address.required' => 'Address is required.',
            'status.in' => 'Invalid status value.',
            'society_id.exists' => 'Invalid society ID.',
            'role_id.exists' => 'Invalid role ID.',
            'guard_image.required' => 'Guard image is required.',
            'guard_image.image' => 'Guard image must be an image file.',
            'guard_image.mimes' => 'Guard image must be of type jpeg, png, jpg, or gif.',
            'documents.required' => 'Documents are required.',
            'documents.file' => 'Documents must be a valid file.',
            'documents.mimes' => 'Documents must be of type pdf, doc, or docx.',
        ];

        // Validate input (excluding files)
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'mobile' => 'required|string|unique:users,mobile',
            'otp' => 'sometimes|string',
            'gate_no' => 'required|string|max:255',
            'address' => 'required|string',
            'status' => 'nullable|in:active,deactive',
            'society_id' => 'nullable|exists:societies,id',
            'role_id' => 'nullable|exists:roles,id',
            'guard_image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'documents' => 'required|array',
            'documents.*' => 'file',
        ], $messages);

        // Return errors if validation fails
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        // Check if the user is an admin
        $user = auth()->user();
        if ($user->role_id !== Role::where('name', 'admin')->first()->id) {
            return response()->json([
                'status' => false,
                'message' => 'Forbidden. Only an admin can register a security guard.'
            ], 403);
        }

        // Create security guard in users table
        $securityUser = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'mobile' => (int)$request->mobile,
            'otp' => $request->otp ?? '0096',
            'status' => $request->status ?? 'active',
            'society_id' => $user->society_id,
            'role_id' => $request->role_id ?? Role::where('name', 'security')->first()->id,
        ]);

        // Assign security role in user_roles table
        $role = Role::where('name', 'security')->first();
        $securityUser->roles()->attach($role);

        // Store the guard image in public/storage/guard_images
        $guardImagePath = $this->storeFileInPublicFolder($request->file('guard_image'), 'guard_images');

        // Store multiple documents and generate their paths in public/storage/guard_documents
        $documentPaths = [];
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $document) {
                // Get the original file name
                $fileName = $document->getClientOriginalName();

                // Move the file to public/storage/guard_documents
                $document->move(public_path('storage/guard_documents'), $fileName);

                // Add the relative path for access
                $documentPaths[] = 'guard_documents/' . $fileName;
            }
        }

        // Create security guard entry in securities table, linking the user_id
        $security = Security::create([
            'user_id' => $securityUser->id, // Link the security guard with the user
            'guard_name' => $securityUser->first_name . ' ' . $securityUser->last_name,
            'gate_no' => $request->gate_no,
            'address' => $request->address,
            'mobile' => $securityUser->mobile,
            'guard_image' => $guardImagePath,  // Store the relative path
            'documents' => json_encode($documentPaths), // Store the relative paths as JSON array
            'status' => $request->status ?? 'active',
            'society_id' => $user->society_id,
            'details' => $request->details ?? '',
        ]);

        // Create entry in gate_details table
        GateDetail::create([
            'society_id' => $user->society_id,
            'gate_no' => $request->gate_no,
            'security_id' => $security->id,
            'gate_mobile' => $securityUser->mobile,
            'status' => $request->status ?? 'active',
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Security guard added successfully',
            'data' => $security
        ], 201);
    }










    protected function storeFileInPublicFolder($file, $folder)
    {
        // Generate a unique file name
        $filename = time() . '_' . preg_replace("/[^A-Za-z0-9\-_\.]/", '_', $file->getClientOriginalName());
        $filename = str_replace(' ', '_', $filename);
        // Move the file to the desired folder in public/storage
        $file->move(public_path("storage/{$folder}"), $filename);

        // Return the relative path to the file
        return "{$folder}/{$filename}";
    }
}
