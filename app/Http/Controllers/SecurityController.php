<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Security;
use App\Models\UserRole;
use App\Models\GateDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SecurityController extends Controller
{
    // Display a listing of the securities (by user_id if provided)
    // public function index(Request $request)
    // {
    //     $securities = Security::all();

    //     // Add full URLs for images and documents
    //     $securitiesWithUrls = $securities->map(function ($security) {
    //         return [
    //             'id' => $security->id,
    //             'guard_name' => $security->guard_name,
    //             'mobile' => $security->mobile,
    //             'address' => $security->address,
    //             'gate_no' => $security->gate_no,
    //             'details' => $security->details,
    //             'guard_image' => env('APP_URL') . '/public/storage/' . $security->guard_image,
    //             'documents' => env('APP_URL') . '/public/storage/' . $security->documents,
    //             'status' => $security->status,
    //         ];
    //     });

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Securities retrieved successfully.',
    //         'data' => $securitiesWithUrls,
    //     ]);
    // }
    // Store a new security record
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

    // // Show a specific security record
    // public function show(Request $request)
    // {
    //     $validatedData = $request->validate([
    //         'id' => 'required|integer|exists:securities,id',
    //     ]);

    //     // Retrieve the security record by id
    //     $security = Security::findOrFail($request->id);

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Security retrieved successfully.',
    //         'data' => [
    //             'id' => $security->id,
    //             'guard_name' => $security->guard_name,
    //             'mobile' => $security->mobile,
    //             'address' => $security->address,
    //             'gate_no' => $security->gate_no,
    //             'details' => $security->details,
    //             'guard_image' => $security->guard_image,
    //             'documents' => $security->documents,
    //             'status' => $security->status,
    //         ],
    //     ]);
    // }

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

    // Update a specific security record
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|integer|exists:securities,id',
            'guard_name' => 'nullable|string|max:50',
            'mobile' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'gate_no' => 'nullable|integer',
            'details' => 'nullable|string',
            'guard_image' => 'nullable|string|max:256',
            'documents' => 'nullable|array',
            'status' => 'nullable|in:active,deactive',
        ]);

        $security = Security::findOrFail($request->id);
        $security->update($validatedData);

        return response()->json(['message' => 'Security updated successfully.', 'data' => $security]);
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

    // // Display all securities with associated gate details
    // public function index(Request $request)
    // {
    //     $securities = Security::whereHas('gateDetails')->get(); // Filter only securities with gate details

    //     $securitiesWithDetails = $securities->map(function ($security, $index) {
    //         $gateDetails = $security->gateDetails->first(); // Get the first associated gate detail
    //         return [
    //             'id' => $security->id,
    //             'no' => $index + 1,
    //             'guard_name' => $security->guard_name,
    //             'personal_mobile' => $security->mobile,
    //             'address' => $security->address,
    //             'gate_no' => $gateDetails->gate_no ?? null, // Get gate number from gate details
    //             'gate_mobile' => $gateDetails->gate_mobile ?? null, // Get gate mobile from gate details
    //             'details' => $security->details,
    //             'guard_image' => $this->getFullUrl($security->guard_image),
    //             'documents' => $this->getFullUrls($security->documents),
    //             'status' => $security->status,
    //         ];
    //     });

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Securities retrieved successfully.',
    //         'data' => $securitiesWithDetails,
    //     ]);
    // }

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



    // // Show a specific security record by id with gate details
    // public function show(Request $request)
    // {
    //     $validatedData = $request->validate([
    //         'id' => 'required|integer|exists:securities,id',
    //     ]);

    //     $security = Security::with('gateDetails')->findOrFail($request->id);

    //     $gateDetails = $security->gateDetails->first(); // Get the first associated gate detail

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Security retrieved successfully.',
    //         'data' => [
    //             'id' => $security->id,
    //             'no' => 1,
    //             'guard_name' => $security->guard_name,
    //             'personal_mobile' => $security->mobile,
    //             'address' => $security->address,
    //             'gate_no' => $gateDetails->gate_no ?? null,
    //             'gate_mobile' => $gateDetails->gate_mobile ?? null,
    //             'details' => $security->details,
    //             'guard_image' => $this->getFullUrl($security->guard_image),
    //             'documents' => $this->getFullUrls($security->documents),
    //             'status' => $security->status,
    //         ],
    //     ]);
    // }




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



    // public function registerSecurity(Request $request)
    // {
    //     // Validate the incoming data
    //     $validatedData = $request->validate([
    //         'first_name' => 'required|string|max:255',
    //         'last_name' => 'required|string|max:255',
    //         'mobile' => 'required|string|max:15|unique:users,mobile',
    //         'otp' => 'required|string',
    //         'gate_no' => 'required|string|max:255',
    //         'address' => 'required|string',
    //         'guard_image' => 'required|image|mimes:jpeg,png,jpg,gif',
    //         'documents' => 'required|file|mimes:pdf,doc,docx',
    //         'status' => 'nullable|in:active,deactive',
    //         'society_id' => 'nullable|exists:societies,id', // Assuming you have a societies table
    //         'role' => 'nullable|in:security', // Only allow "security" role
    //     ]);

    //     // Check if the user is an admin
    //     $user = auth()->user();
    //     if ($user->role !== 'admin') {
    //         return response()->json(['message' => 'Forbidden'], 403);
    //     }

    //     // Create the user record for the security guard
    //     $securityUser = User::create([
    //         'first_name' => $validatedData['first_name'],
    //         'last_name' => $validatedData['last_name'],
    //         'mobile' => $validatedData['mobile'],
    //         'otp' => $validatedData['otp'],
    //         'gate_no' => $validatedData['gate_no'],
    //         'address' => $validatedData['address'],
    //         'guard_image' => $request->file('guard_image')->store('images'),
    //         'documents' => $request->file('documents')->store('documents'),
    //         'status' => $validatedData['status'] ?? 'active',
    //         'society_id' => $validatedData['society_id'] ?? auth()->user()->society_id,
    //         'role' => 'security', // Set the role to 'security'
    //     ]);

    //     // Add role to user_roles table
    //     $role = Role::where('name', 'security')->first();
    //     $securityUser->roles()->attach($role);

    //     // Create security guard record
    //     Security::create([
    //         'user_id' => $securityUser->id,
    //         'gate_no' => $validatedData['gate_no'],
    //         'address' => $validatedData['address'],
    //         'guard_image' => $request->file('guard_image')->store('images'),
    //         'documents' => $request->file('documents')->store('documents'),
    //         'status' => $validatedData['status'] ?? 'active',
    //         'society_id' => $validatedData['society_id'] ?? auth()->user()->society_id,
    //     ]);

    //     return response()->json(['message' => 'Security guard added successfully'], 201);
    // }

    // public function registerSecurity(Request $request)
    // {
    //     // Custom validation messages
    //     $messages = [
    //         'first_name.required' => 'First name is required.',
    //         'last_name.required' => 'Last name is required.',
    //         'mobile.required' => 'Mobile number is required.',
    //         'mobile.unique' => 'This mobile number is already registered.',
    //         'otp.required' => 'OTP is required.',
    //         'gate_no.required' => 'Gate number is required.',
    //         'address.required' => 'Address is required.',
    //         'status.in' => 'Invalid status value.',
    //         'society_id.exists' => 'Invalid society ID.',
    //         'role_id.exists' => 'Invalid role ID.',
    //         'guard_image.required' => 'Guard image is required.',
    //         'guard_image.image' => 'Guard image must be an image file.',
    //         'guard_image.mimes' => 'Guard image must be of type jpeg, png, jpg, or gif.',
    //         'documents.required' => 'Documents are required.',
    //         'documents.file' => 'Documents must be a valid file.',
    //         'documents.mimes' => 'Documents must be of type pdf, doc, or docx.',
    //     ];

    //     // Validate input (excluding files)
    //     $validator = Validator::make($request->all(), [
    //         'first_name' => 'required|string|max:255',
    //         'last_name' => 'required|string|max:255',
    //         'mobile' => 'required|string',
    //         'otp' => 'required|string',
    //         'gate_no' => 'required|string|max:255',
    //         'address' => 'required|string',
    //         'status' => 'nullable|in:active,deactive',
    //         'society_id' => 'nullable|exists:societies,id',
    //         'role_id' => 'nullable|exists:roles,id',
    //         'guard_image' => 'required|image|mimes:jpeg,png,jpg,gif',
    //         'documents' => 'required|file|mimes:pdf,doc,docx',
    //     ], $messages);
    //     // dd(auth()->user());
    //     // Return errors if validation fails
    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Validation errors',
    //             'errors' => $validator->errors()
    //         ], 422);
    //     }

    //     // Check if the user is an admin
    //     $user = auth()->user();
    //     if ($user->role_id !== Role::where('name', 'admin')->first()->id) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Forbidden. Only an admin can register a security guard.'
    //         ], 403);
    //     }
    //     // dd($user);
    //     // Create security guard in users table
    //     $securityUser = User::create([
    //         'first_name' => $request->first_name,
    //         'last_name' => $request->last_name,
    //         'mobile' => (int)$request->mobile,
    //         'otp' => $request->otp,
    //         'status' => $request->status ?? 'active',
    //         'society_id' =>  $user->society_id,
    //         'role_id' => $request->role_id ?? Role::where('name', 'security')->first()->id,
    //     ]);

    //     // Assign security role in user_roles table
    //     $role = Role::where('name', 'security')->first();
    //     $securityUser->roles()->attach($role);

    //     // Create security guard entry in securities table
    //     $security = Security::create([
    //         'user_id' => $securityUser->id,
    //         'guard_name' => $securityUser->first_name . ' ' . $securityUser->last_name,
    //         'gate_no' => $request->gate_no,
    //         'address' => $request->address,
    //         'mobile' => $securityUser->mobile,
    //         'guard_image' => $request->file('guard_image')->store('images'),
    //         'documents' => $request->file('documents')->store('documents'),
    //         'status' => $request->status ?? 'active',
    //         'society_id' =>  $user->society_id,
    //         'details' => $request->details,
    //     ]);

    //     // Create entry in gate_details table
    //     GateDetail::create([
    //         'society_id' => $user->society_id,
    //         'gate_no' => $request->gate_no,
    //         'security_id' => $security->id,
    //         'gate_mobile' => $request->mobile,
    //         'status' => $request->status ?? 'active',
    //     ]);

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Security guard added successfully',
    //         'data' => $security
    //     ], 201);
    // }

    // public function registerSecurity(Request $request)
    // {
    //     // Custom validation messages
    //     $messages = [
    //         'first_name.required' => 'First name is required.',
    //         'last_name.required' => 'Last name is required.',
    //         'mobile.required' => 'Mobile number is required.',
    //         'mobile.unique' => 'This mobile number is already registered.',
    //         'otp.required' => 'OTP is required.',
    //         'gate_no.required' => 'Gate number is required.',
    //         'address.required' => 'Address is required.',
    //         'status.in' => 'Invalid status value.',
    //         'society_id.exists' => 'Invalid society ID.',
    //         'role_id.exists' => 'Invalid role ID.',
    //         'guard_image.required' => 'Guard image is required.',
    //         'guard_image.image' => 'Guard image must be an image file.',
    //         'guard_image.mimes' => 'Guard image must be of type jpeg, png, jpg, or gif.',
    //         'documents.required' => 'Documents are required.',
    //         'documents.file' => 'Documents must be a valid file.',
    //         'documents.mimes' => 'Documents must be of type pdf, doc, or docx.',
    //     ];

    //     // Validate input (excluding files)
    //     $validator = Validator::make($request->all(), [
    //         'first_name' => 'required|string|max:255',
    //         'last_name' => 'required|string|max:255',
    //         'mobile' => 'required|string',
    //         'otp' => 'required|string',
    //         'gate_no' => 'required|string|max:255',
    //         'address' => 'required|string',
    //         'status' => 'nullable|in:active,deactive',
    //         'society_id' => 'nullable|exists:societies,id',
    //         'role_id' => 'nullable|exists:roles,id',
    //         'guard_image' => 'required|image|mimes:jpeg,png,jpg,gif',
    //         'documents' => 'required|file',
    //     ], $messages);

    //     // Return errors if validation fails
    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Validation errors',
    //             'errors' => $validator->errors()
    //         ], 422);
    //     }
    //     // dd($request->file('documents'));
    //     // Check if the user is an admin
    //     $user = auth()->user();
    //     if ($user->role_id !== Role::where('name', 'admin')->first()->id) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Forbidden. Only an admin can register a security guard.'
    //         ], 403);
    //     }

    //     // Create security guard in users table
    //     $securityUser = User::create([
    //         'first_name' => $request->first_name,
    //         'last_name' => $request->last_name,
    //         'mobile' => (int)$request->mobile,
    //         'otp' => $request->otp,
    //         'status' => $request->status ?? 'active',
    //         'society_id' => $user->society_id,
    //         'role_id' => $request->role_id ?? Role::where('name', 'security')->first()->id,
    //     ]);

    //     // Assign security role in user_roles table
    //     $role = Role::where('name', 'security')->first();
    //     $securityUser->roles()->attach($role);

    //     // Store the guard image in public/storage/guard_images
    //     $guardImagePath = $this->storeFileInPublicFolder($request->file('guard_image'), 'guard_images');

    //     // Store multiple documents and generate their paths in public/storage/guard_documents
    //     $documentPaths = [];
    //     // dd('hhh ', $request->file('documents'));
    //     // foreach ($request->file('documents') as $document) {
    //     //     // Ensure the document is stored in the correct directory

    //     //     $documentPath = $document->store('guard_documents', 'public');
    //     //     $documentPaths[] = $documentPath;
    //     // }
    //     if ($request->hasFile('documents')) {
    //         foreach ($request->file('documents') as $document) {
    //             // Get the original file name
    //             $fileName = $document->getClientOriginalName();

    //             // Move the file to public/storage/guard_documents
    //             $document->move(public_path('storage/guard_documents'), $fileName);

    //             // Add the relative path for access
    //             $documentPaths[] = 'guard_documents/' . $fileName;
    //         }
    //     }

    //     // dd($documentPaths);
    //     // Create security guard entry in securities table, linking the user_id
    //     $security = Security::create([
    //         'user_id' => $securityUser->id, // Link the security guard with the user
    //         'guard_name' => $securityUser->first_name . ' ' . $securityUser->last_name,
    //         'gate_no' => $request->gate_no,
    //         'address' => $request->address,
    //         'mobile' => $securityUser->mobile,
    //         'guard_image' => $guardImagePath,  // Store the relative path
    //         'documents' => json_encode($documentPaths), // Store the relative paths as JSON array
    //         'status' => $request->status ?? 'active',
    //         'society_id' => $user->society_id,
    //         'details' => $request->details,
    //     ]);

    //     // Create entry in gate_details table
    //     GateDetail::create([
    //         'society_id' => $user->society_id,
    //         'gate_no' => $request->gate_no,
    //         'security_id' => $security->id,
    //         'gate_mobile' => $request->mobile,
    //         'status' => $request->status ?? 'active',
    //     ]);

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Security guard added successfully',
    //         'data' => $security
    //     ], 201);
    // }


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
            'documents.*.file' => 'Each document must be a valid file.',
            // 'documents.required' => 'Documents are required.',
            // 'documents.file' => 'Documents must be a valid file.',
            // 'documents.mimes' => 'Documents must be of type pdf, doc, or docx.',
        ];
        // Validate input (excluding files)
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'mobile' => 'required|string|unique:users,mobile',
            'otp' => 'required|string',
            'gate_no' => 'required|string|max:255',
            'address' => 'required|string',
            'status' => 'nullable|in:active,deactive',
            'society_id' => 'nullable|exists:societies,id',
            'role_id' => 'nullable|exists:roles,id',
            'guard_image' => 'required|image|mimes:jpeg,png,jpg,gif',
            // 'documents.*' => 'required|file|array',  // Assuming multiple documents
            'documents' => 'nullable|array',  // Ensure documents is an array
            'documents.*' => 'file', // Allow various file types for documents
            // 'documents.*' => 'file|array', // File validation for each document
            // 'documents.*' => 'file',
        ], $messages);

        // dd($request->file('documents'));
        // dd(is_array($request->file('documents')));
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
        // dd($request->file('documents'));
        // Step 1: Create security user in the 'users' table
        $securityUser = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'mobile' => $request->mobile,
            'otp' => $request->otp,
            'status' => $request->status ?? 'active',
            'society_id' => $user->society_id,
            'role_id' => $request->role_id ?? Role::where('name', 'security')->first()->id,
        ]);

        // dd($securityUser->id);
        $usersID = $securityUser->id;

        // Step 2: Assign security role in user_roles table
        $role = Role::where('name', 'security')->first();
        $securityUser->roles()->attach($role);

        // Step 3: Store guard image in public/storage/guard_images
        $guardImagePath = $this->storeFileInPublicFolder($request->file('guard_image'), 'guard_images');

        // Step 4: Store multiple documents and generate their paths in public/storage/guard_documents
        // $documentPaths = [];
        $documentPaths = [];
        if ($request->hasFile('documents')) {
            // If it's multiple files
            if (is_array($request->file('documents'))) {
                foreach ($request->file('documents') as $document) {
                    // Store each document and get the path
                    $documentPath = $this->storeFileInPublicFolder($document, 'guard_documents');
                    $documentPaths[] = $documentPath;
                }
            } else {
                // If it's a single file
                $documentPath = $this->storeFileInPublicFolder($request->file('documents'), 'guard_documents');
                $documentPaths[] = $documentPath;
            }
        }




        // Step 5: Create security guard entry in the 'securities' table, linking to the user
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
            'details' => $request->details,
        ]);

        // Step 6: Create entry in gate_details table
        GateDetail::create([
            'society_id' => $user->society_id,
            'gate_no' => $request->gate_no,
            'security_id' => $security->id,
            'gate_mobile' => $request->mobile,
            'status' => $request->status ?? 'active',
        ]);

        // Return success response
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