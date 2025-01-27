<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
        // Validate the incoming request data
        $request->validate([
            'visitor_name' => 'required|string|max:50',
            'mobile' => 'required|string|max:10',
            'date' => 'required|date',
            'reason' => 'required|string|max:255',
            'visitor_status' => 'required|in:Pending,Active,decline',
            'prof_image' => 'required|string|max:256',
            'user_id' => 'required|exists:users,id',  // Ensure the user exists
            'status' => 'required|in:active,deactive',
        ]);

        // Fetch the user based on the provided user_id
        $user = User::find($request->user_id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Add the user's block_number to the visitor data
        $visitorData = $request->all();
        $visitorData['block_number'] = $user->block_number;  // Add block_number from the user

        // Create the visitor record
        $visitor = Visitor::create($visitorData);

        // Return the newly created visitor
        return response()->json($visitor, 201);
    }


    // Update a visitor
    public function update(Request $request, $id)
    {
        // Find the visitor by ID
        $visitor = Visitor::find($id);

        if (!$visitor) {
            return response()->json(['message' => 'Visitor not found'], 404);
        }

        // Validate the request data before updating
        $request->validate([
            'visitor_name' => 'sometimes|required|string|max:50',
            'mobile' => 'sometimes|required|string|max:10',
            'date' => 'sometimes|required|date',
            'reason' => 'sometimes|required|string|max:255',
            'visitor_status' => 'sometimes|required|in:PENDING,active,decline',
            'prof_image' => 'sometimes|required|string|max:256',
            'user_id' => 'sometimes|required|exists:users,id',
            'status' => 'sometimes|required|in:active,deactive',
        ]);

        // Update the visitor with validated data
        $visitor->update($request->all());

        return response()->json($visitor, 200);
    }

    // Delete a visitor
    public function destroy($id)
    {
        // Find the visitor by ID
        $visitor = Visitor::find($id);

        if (!$visitor) {
            return response()->json(['message' => 'Visitor not found'], 404);
        }

        // Delete the visitor
        $visitor->delete();

        return response()->json(null, 204); // Return success with no content
    }
}
