<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class VisitorController extends Controller
{
    // public function index(Request $request)
    // {
    //     $id = $request->input('id');
    //     $userId = $request->input('user_id');

    //     if ($id) {
    //         // Fetch specific visitor by id or all visitors if id is 'all'
    //         if ($id === 'all') {
    //             $visitors = Visitor::orderBy('created_at', 'desc')->get();
    //         } else {
    //             $visitor = Visitor::find($id);
    //             if (!$visitor) {
    //                 return response()->json([
    //                     'status' => false,
    //                     'message' => 'Visitor not found',
    //                     'data' => []
    //                 ], 200);
    //             }
    //             $visitors = collect([$visitor]);
    //         }
    //     } elseif ($userId) {
    //         // Fetch visitors for specific user_id or all users if user_id is 'all'
    //         if ($userId === 'all') {
    //             $visitors = Visitor::orderBy('created_at', 'desc')->get();
    //         } else {
    //             $visitors = Visitor::where('user_id', $userId)
    //                 ->orderBy('created_at', 'desc') // Ensure visitors are ordered by created_at
    //                 ->get();
    //             if ($visitors->isEmpty()) {
    //                 return response()->json([
    //                     'status' => false,
    //                     'message' => 'No visitors found for this user',
    //                     'data' => []
    //                 ], 200);
    //             }
    //         }
    //     } else {
    //         // If neither id nor user_id is provided
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Either id or user_id is required',
    //             'data' => []
    //         ], 200);
    //     }

    //     // Format the response
    //     $data = [];
    //     foreach ($visitors as $index => $visitor) {
    //         $data[] = [
    //             'no' => $index + 1,
    //             'id' => $visitor->id,
    //             'user_id' => $visitor->user_id,
    //             'blockNumber' => $visitor->block_number,
    //             'image' => $this->getVisitorImage($visitor), // Dynamic image based on visitor
    //             'visitorName' => $visitor->visitor_name,
    //             'date' => \Carbon\Carbon::parse($visitor->date)->format('d-m-Y'), // Format date as required
    //             'reason' => $visitor->reason,
    //             'mobile' => $visitor->mobile,
    //             'status' => $visitor->visitor_status,
    //         ];
    //     }

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Visitors fetched successfully',
    //         'data' => $data
    //     ]);
    // }


    public function index(Request $request)
    {
        // Get logged-in user's society_id
        $loggedInUser = auth()->user();
        $loggedInSocietyId = $loggedInUser->society_id;

        // Get 'id' and 'user_id' from the request input
        $id = $request->input('id');
        $userId = $request->input('user_id');

        if ($id) {
            // Fetch a specific visitor by ID or all visitors if 'id' is 'all'
            if ($id === 'all') {
                // Get all visitors where the associated user belongs to the same society as the logged-in user
                $visitors = Visitor::whereHas('user', function ($query) use ($loggedInSocietyId) {
                    $query->where('society_id', $loggedInSocietyId);
                })
                    ->orderBy('created_at', 'desc')
                    ->get();
            } else {
                // Fetch a specific visitor by ID
                $visitor = Visitor::find($id);

                if (!$visitor) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Visitor not found',
                        'data' => []
                    ], 200);
                }

                // Ensure the visitor belongs to a user in the same society
                $visitorUser = $visitor->user;
                if (!$visitorUser || $visitorUser->society_id !== $loggedInSocietyId) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Visitor not authorized',
                        'data' => []
                    ], 200);
                }

                $visitors = collect([$visitor]);
            }
        } elseif ($userId) {
            // Fetch visitors for a specific user_id or all users if 'user_id' is 'all'
            if ($userId === 'all') {
                // Get all visitors where the associated user belongs to the same society as the logged-in user
                $visitors = Visitor::whereHas('user', function ($query) use ($loggedInSocietyId) {
                    $query->where('society_id', $loggedInSocietyId);
                })
                    ->orderBy('created_at', 'desc')
                    ->get();
            } else {
                // Fetch visitors for a specific user
                $user = User::find($userId);

                if (!$user || $user->society_id !== $loggedInSocietyId) {
                    return response()->json([
                        'status' => false,
                        'message' => 'User not authorized or does not belong to your society',
                        'data' => []
                    ], 200);
                }

                $visitors = Visitor::where('user_id', $userId)
                    ->orderBy('created_at', 'desc')
                    ->get();

                if ($visitors->isEmpty()) {
                    return response()->json([
                        'status' => false,
                        'message' => 'No visitors found for this user',
                        'data' => []
                    ], 200);
                }
            }
        } else {
            // If neither 'id' nor 'user_id' is provided
            return response()->json([
                'status' => false,
                'message' => 'Either id or user_id is required',
                'data' => []
            ], 200);
        }

        // Format the response
        $data = [];
        foreach ($visitors as $index => $visitor) {
            $data[] = [
                'no' => $index + 1,
                'id' => $visitor->id,
                'user_id' => $visitor->user_id,
                'blockNumber' => $visitor->block_number,
                'image' => $this->getVisitorImage($visitor), // Generate dynamic visitor image
                'visitorName' => $visitor->visitor_name,
                'date' => \Carbon\Carbon::parse($visitor->date)->format('d-m-Y'), // Format date
                'reason' => $visitor->reason,
                'mobile' => $visitor->mobile,
                'status' => $visitor->visitor_status,
            ];
        }

        return response()->json([
            'status' => true,
            'message' => 'Visitors fetched successfully',
            'data' => $data
        ]);
    }


    private function getVisitorImage($visitor)
    {
        // Return default image path or logic based on status or other conditions
        if ($visitor->prof_image) {
            return asset('storage/' . $visitor->prof_image); // Assuming you store image paths
        } else {
            // Return a default image or some placeholder
            return 'Images.logo'; // You can change this to an actual URL or path
        }
    }


    // Store a new visitor
    public function store(Request $request)
    {
        // Validate request inputs
        $rules = [
            'visitor_name' => 'required|string|max:50',
            'mobile' => 'required|string|max:10',
            'date' => 'required|date',
            'reason' => 'required|string|max:255',
            'visitor_status' => 'nullable|in:Pending,Active,Decline', // Nullable, defaults to Pending
            'prof_image' => 'nullable|file|mimes:jpeg,png,jpg|max:2048', // Can be a file or null
            'user_id' => 'required|integer', // Ensure it's an integer but check existence manually
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Manually fetch the user
        $user = User::where('id', $request->user_id)->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Missing parameter: user_id is invalid or not found',
                'data' => null
            ], 422);
        }

        // Ensure the logged-in user belongs to the same society
        if ($user->society_id !== auth()->user()->society_id) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized: User does not belong to the same society',
                'data' => null
            ], 403);
        }

        // Handle visitor profile image upload
        $profImagePath = 'visitor_images/avatar.png'; // Default image

        if ($request->hasFile('prof_image')) {
            // Get the uploaded file
            $file = $request->file('prof_image');
            $fileName = time() . '_' . $file->getClientOriginalName(); // Create a unique filename
            $destinationPath = public_path('storage/visitor_images'); // Define the directory in public/storage

            // Move the file to the directory
            $file->move($destinationPath, $fileName);

            // Store the relative path in the database
            $profImagePath = 'visitor_images/' . $fileName;
        }

        // Prepare visitor data
        $visitorData = $request->all();
        $visitorData['block_number'] = $user->block_number;
        $visitorData['status'] = $request->status ?? 'active'; // Default to active if not provided
        $visitorData['visitor_status'] = $request->visitor_status ?? 'Pending'; // Default to Pending
        $visitorData['prof_image'] = $profImagePath; // Store the profile image path

        // Create the visitor record
        $visitor = Visitor::create($visitorData);

        // Return the newly created visitor
        return response()->json([
            'status' => true,
            'message' => 'Visitor created successfully',
            'data' => $visitor
        ], 201);
    }



    // Update a visitor
    public function update(Request $request)
    {
        // Validate request inputs
        $rules = [
            'id' => 'required|exists:visitors,id', // Ensure ID exists in the visitors table
            'visitor_name' => 'sometimes|required|string|max:50',
            'mobile' => 'sometimes|required|string|max:10',
            'date' => 'sometimes|required|date',
            'reason' => 'sometimes|required|string|max:255',
            'visitor_status' => 'sometimes|in:Pending,Active,Decline', // Nullable, defaults to Pending
            'prof_image' => 'sometimes|file|mimes:jpeg,png,jpg|max:2048', // Image file optional
            'user_id' => 'sometimes|required|integer', // Ensure user_id is valid
            'status' => 'sometimes|in:active,deactive',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Find the visitor by ID
        $visitor = Visitor::find($request->id);

        if (!$visitor) {
            return response()->json([
                'status' => false,
                'message' => 'Visitor not found',
                'data' => null
            ], 404);
        }

        // If `user_id` is provided, check if it exists and belongs to the same society
        if ($request->has('user_id')) {
            $user = User::where('id', $request->user_id)->first();

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Missing parameter: user_id is invalid or not found',
                    'data' => null
                ], 422);
            }

            if ($user->society_id !== auth()->user()->society_id) {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthorized: User does not belong to the same society',
                    'data' => null
                ], 403);
            }

            // Assign new block_number if user_id is changed
            $visitor->block_number = $user->block_number;
        }

        // Handle profile image update
        if ($request->hasFile('prof_image')) {
            // Get the uploaded file
            $file = $request->file('prof_image');
            $fileName = time() . '_' . $file->getClientOriginalName(); // Unique filename
            $destinationPath = public_path('storage/visitor_images'); // Define storage directory

            // Move the file
            $file->move($destinationPath, $fileName);

            // Store relative path in the database
            $visitor->prof_image = 'visitor_images/' . $fileName;
        }

        // Update visitor fields if provided
        if ($request->has('visitor_name')) {
            $visitor->visitor_name = $request->visitor_name;
        }
        if ($request->has('mobile')) {
            $visitor->mobile = $request->mobile;
        }
        if ($request->has('date')) {
            $visitor->date = $request->date;
        }
        if ($request->has('reason')) {
            $visitor->reason = $request->reason;
        }
        if ($request->has('visitor_status')) {
            $visitor->visitor_status = $request->visitor_status ?? 'Pending';
        }
        if ($request->has('status')) {
            $visitor->status = $request->status;
        }

        // Save the updated visitor record
        $visitor->save();

        return response()->json([
            'status' => true,
            'message' => 'Visitor updated successfully',
            'data' => $visitor
        ], 200);
    }



    // Delete a visitor
    public function destroy(Request $request)
    {
        // Validate that 'id' and 'action' are provided in the request
        $request->validate([
            'id' => 'required|exists:visitors,id',
            'action' => 'required|in:deactivate,delete'
        ]);

        // Find the visitor by ID
        $visitor = Visitor::find($request->id);

        if (!$visitor) {
            return response()->json(['message' => 'Visitor not found'], 404);
        }

        // Check if the authenticated user is an admin or super-admin
        $user = auth()->user(); // Get the authenticated user
        if (!in_array($user->role_id, [1, 2])) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized: Only admin or super-admin can delete a visitor',
            ], 403);
        }

        // Check the action type from the request
        $action = $request->input('action'); // Get action from the request body

        if ($action == 'deactivate') {
            // Set status to 'deactive' instead of deleting the record
            $visitor->status = 'deactive';
            $visitor->save();

            return response()->json([
                'status' => true,
                'message' => 'Visitor deactivated successfully',
                'data' => $visitor
            ], 200);
        } elseif ($action == 'delete') {
            // Permanently delete the visitor record
            $visitor->delete();

            return response()->json([
                'status' => true,
                'message' => 'Visitor permenantly deleted successfully',
                'data' => $visitor
            ], 200);
        }

        return response()->json(['message' => 'Invalid action'], 400);
    }
}
