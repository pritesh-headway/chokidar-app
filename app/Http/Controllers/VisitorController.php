<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class VisitorController extends Controller
{
    public function index(Request $request)
    {

        $loggedInUser = auth()->user();
        $loggedInSocietyId = $loggedInUser->society_id;
        $id = $request->input('id');
        $userId = $request->input('user_id');

        if ($id) {

            if ($id === 'all') {

                $visitors = Visitor::whereHas('user', function ($query) use ($loggedInSocietyId) {
                    $query->where('society_id', $loggedInSocietyId);
                })
                    ->orderBy('created_at', 'desc')
                    ->get();
            } else {

                $visitor = Visitor::find($id);

                if (!$visitor) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Visitor not found',
                        'data' => []
                    ], 200);
                }
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

            if ($userId === 'all') {

                $visitors = Visitor::whereHas('user', function ($query) use ($loggedInSocietyId) {
                    $query->where('society_id', $loggedInSocietyId);
                })
                    ->orderBy('created_at', 'desc')
                    ->get();
            } else {

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

            return response()->json([
                'status' => false,
                'message' => 'Either id or user_id is required',
                'data' => []
            ], 200);
        }
        $data = [];
        foreach ($visitors as $index => $visitor) {
            $data[] = [
                'no' => $index + 1,
                'id' => $visitor->id,
                'user_id' => $visitor->user_id,
                'blockNumber' => $visitor->block_number,
                'image' => $this->getVisitorImage($visitor),
                'visitorName' => $visitor->visitor_name,
                'date' => \Carbon\Carbon::parse($visitor->date)->format('d-m-Y'),
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

        if ($visitor->prof_image) {
            return asset('storage/' . $visitor->prof_image);
        } else {

            return 'Images.logo';
        }
    }
    public function store(Request $request)
    {

        $rules = [
            'visitor_name' => 'required|string|max:50',
            'mobile' => 'required|string|max:10',
            'date' => 'required|date',
            'reason' => 'required|string|max:255',
            'visitor_status' => 'nullable|in:Pending,Active,Decline',
            'prof_image' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
            'user_id' => 'required|integer',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }
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
        $profImagePath = 'visitor_images/avatar.png';

        if ($request->hasFile('prof_image')) {

            $file = $request->file('prof_image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $destinationPath = public_path('storage/visitor_images');
            $file->move($destinationPath, $fileName);
            $profImagePath = 'visitor_images/' . $fileName;
        }
        $visitorData = $request->all();
        $visitorData['block_number'] = $user->block_number;
        $visitorData['status'] = $request->status ?? 'active';
        $visitorData['visitor_status'] = $request->visitor_status ?? 'Pending';
        $visitorData['prof_image'] = $profImagePath;
        $visitor = Visitor::create($visitorData);
        return response()->json([
            'status' => true,
            'message' => 'Visitor created successfully',
            'data' => $visitor
        ], 201);
    }
    public function update(Request $request)
    {

        $rules = [
            'id' => 'required|exists:visitors,id',
            'visitor_name' => 'sometimes|required|string|max:50',
            'mobile' => 'sometimes|required|string|max:10',
            'date' => 'sometimes|required|date',
            'reason' => 'sometimes|required|string|max:255',
            'visitor_status' => 'sometimes|in:Pending,Active,Decline',
            'prof_image' => 'sometimes|file|mimes:jpeg,png,jpg|max:2048',
            'user_id' => 'sometimes|required|integer',
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
        $visitor = Visitor::find($request->id);

        if (!$visitor) {
            return response()->json([
                'status' => false,
                'message' => 'Visitor not found',
                'data' => null
            ], 404);
        }
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
            $visitor->block_number = $user->block_number;
        }
        if ($request->hasFile('prof_image')) {

            $file = $request->file('prof_image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $destinationPath = public_path('storage/visitor_images');
            $file->move($destinationPath, $fileName);
            $visitor->prof_image = 'visitor_images/' . $fileName;
        }
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
        $visitor->save();

        return response()->json([
            'status' => true,
            'message' => 'Visitor updated successfully',
            'data' => $visitor
        ], 200);
    }
    public function destroy(Request $request)
    {

        $request->validate([
            'id' => 'required|exists:visitors,id',
            'action' => 'required|in:deactivate,delete'
        ]);
        $visitor = Visitor::find($request->id);

        if (!$visitor) {
            return response()->json(['message' => 'Visitor not found'], 404);
        }
        $user = auth()->user();
        if (!in_array($user->role_id, [1, 2])) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized: Only admin or super-admin can delete a visitor',
            ], 403);
        }
        $action = $request->input('action');

        if ($action == 'deactivate') {

            $visitor->status = 'deactive';
            $visitor->save();

            return response()->json([
                'status' => true,
                'message' => 'Visitor deactivated successfully',
                'data' => $visitor
            ], 200);
        } elseif ($action == 'delete') {

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
