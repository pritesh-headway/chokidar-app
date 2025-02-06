<?php

namespace App\Http\Controllers;

use App\Models\BookingAmenity;
use App\Models\User;
use App\Models\Amenity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class BookingAmenityController extends Controller
{
    /**
     * Get all bookings.
     */
    public function index(Request $request)
    {
        $bookings = BookingAmenity::select('id', 'block_name', 'first_name', 'last_name', 'day', 'from', 'to', 'amenity_id', 'user_id', 'mobile', 'booking_status', 'status', 'created_at', 'updated_at')
            ->get();

        $bookings = $bookings->map(function ($booking, $index) {
            $memberName = $booking->first_name . ' ' . $booking->last_name;
            $formattedFrom = \Carbon\Carbon::parse($booking->from)->format('H:i');
            $formattedTo = \Carbon\Carbon::parse($booking->to)->format('H:i');

            return [
                'id' => $booking->id,
                'no' => $index + 1,
                'block_name' => $booking->block_name,
                'member_name' => $memberName,
                'day' => \Carbon\Carbon::parse($booking->day)->format('d-m-Y'),
                'from' => $formattedFrom,
                'to' => $formattedTo,
                'amenity_id' => $booking->amenity_id,
                'user_id' => $booking->user_id,
                'mobile' => $booking->mobile,
                'booking_status' => $booking->booking_status,
                'status' => $booking->status,
                'created_at' => $booking->created_at,
                'updated_at' => $booking->updated_at,
            ];
        });

        return response()->json([
            'status' => true,
            'message' => 'All bookings retrieved successfully.',
            'data' => $bookings
        ]);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required',
            'amenity_id' => 'required',
            'day' => 'required|date',
            'from' => 'required|date_format:H:i',
            'to' => 'required|date_format:H:i|after:from',
            'booking_status' => 'nullable|in:Pending,Approved,Rejected',
        ]);
        $user = User::find($validated['user_id']);
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found.',
                'data' => []
            ], 404);
        }
        $amenity = Amenity::find($validated['amenity_id']);
        if (!$amenity) {
            return response()->json([
                'status' => false,
                'message' => 'Amenity not found.',
                'data' => []
            ], 404);
        }
        $fromTime = $validated['from'] . ':00';
        $toTime = $validated['to'] . ':00';
        $overlap = BookingAmenity::where('amenity_id', $validated['amenity_id'])
            ->where('day', $validated['day'])
            ->where(function ($query) use ($fromTime, $toTime) {
                $query->whereBetween('from', [$fromTime, $toTime])
                    ->orWhereBetween('to', [$fromTime, $toTime]);
            })
            ->exists();

        if ($overlap) {
            return response()->json([
                'status' => false,
                'message' => 'The booking time overlaps with an existing booking for this amenity.',
                'data' => []
            ], 400);
        }
        $bookingAmenity = BookingAmenity::create([
            'user_id' => $validated['user_id'],
            'amenity_id' => $validated['amenity_id'],
            'block_name' => $user->block_number,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'mobile' => $user->mobile,
            'day' => $validated['day'],
            'from' => $fromTime,
            'to' => $toTime,
            'booking_status' => $validated['booking_status'] ?? 'Pending',
            'status' => 'active',
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Booking created successfully.',
            'data' => $bookingAmenity
        ]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:booking_amenities,id',
            'booking_status' => 'sometimes|string|in:Pending,Approved,Rejected',
            'reason' => 'sometimes',
            'from' => 'sometimes|date_format:H:i',
            'to' => 'sometimes|date_format:H:i|after:from',
            'day' => 'sometimes|date_format:Y-m-d',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation errors.',
                'data' => $validator->errors()
            ], 400);
        }

        $booking = BookingAmenity::find($request->id);
        if (!$booking) {
            return response()->json([
                'status' => false,
                'message' => 'Booking not found.',
                'data' => null
            ], 404);
        }

        $user = User::find($booking->user_id);
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User associated with this booking not found.',
                'data' => null
            ], 404);
        }

        $amenity = Amenity::find($booking->amenity_id);
        if (!$amenity) {
            return response()->json([
                'status' => false,
                'message' => 'Amenity associated with this booking not found.',
                'data' => null
            ], 404);
        }
        if ($request->booking_status == 'Rejected') {
            if ($request->reason == null) {
                return response()->json([
                    'status' => false,
                    'message' => 'Reason is required for rejecting.',

                ]);
            } else {
                $booking->reason = $request->reason;
                $booking->booking_status = $request->booking_status;
            }
        } else {
            $booking->booking_status = $request->booking_status;
        }
        if ($request->has('from') && $request->has('to')) {

            $booking->from = $request->from . ':00';
            $booking->to = $request->to . ':00';
        }
        if ($request->has('day')) {
            $booking->day = $request->day;
        }
        $booking->save();

        return response()->json([
            'status' => true,
            'message' => 'Booking updated successfully.',
            'data' => $booking
        ]);
    }
    /**
     * Get a specific booking or bookings by different criteria (id, user_id, or amenity_id).
     */
    public function show(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'sometimes|required|integer|exists:booking_amenities,id',
            'user_id' => 'sometimes|required|integer|exists:users,id',
            'amenity_id' => 'sometimes|required|integer|exists:amenities,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation errors.',
                'data' => $validator->errors()
            ], 400);
        }

        $query = BookingAmenity::select('id', 'block_name', 'first_name', 'last_name', 'from', 'to', 'day', 'amenity_id', 'user_id', 'mobile', 'booking_status', 'status', 'created_at', 'updated_at');
        if ($request->has('id')) {
            $booking = $query->where('id', $request->id)->first();

            if (!$booking) {
                return response()->json([
                    'status' => false,
                    'message' => 'Booking not found.',
                    'data' => null
                ], 404);
            }
            $memberName = $booking->first_name . ' ' . $booking->last_name;
            $formattedFrom = \Carbon\Carbon::parse($booking->from)->format('H:i');
            $formattedTo = \Carbon\Carbon::parse($booking->to)->format('H:i');
            return response()->json([
                'status' => true,
                'message' => 'Booking retrieved successfully.',
                'data' => [
                    'id' => $booking->id,
                    'no' => 1,
                    'block_name' => $booking->block_name,
                    'member_name' => $memberName,
                    'day' => \Carbon\Carbon::parse($booking->day)->format('d-m-Y'),
                    'from' => $formattedFrom,
                    'to' => $formattedTo,
                    'amenity_id' => $booking->amenity_id,
                    'user_id' => $booking->user_id,
                    'mobile' => $booking->mobile,
                    'booking_status' => $booking->booking_status,
                    'status' => $booking->status,
                    'created_at' => $booking->created_at,
                    'updated_at' => $booking->updated_at,
                ]
            ]);
        }
        if ($request->has('user_id')) {
            $bookings = $query->where('user_id', $request->user_id)->get();
            $bookings = $bookings->map(function ($booking, $index) {
                $memberName = $booking->first_name . ' ' . $booking->last_name;
                $formattedFrom = \Carbon\Carbon::parse($booking->from)->format('H:i');
                $formattedTo = \Carbon\Carbon::parse($booking->to)->format('H:i');

                return [
                    'id' => $booking->id,
                    'no' => $index + 1,
                    'block_name' => $booking->block_name,
                    'member_name' => $memberName,
                    'day' => \Carbon\Carbon::parse($booking->day)->format('d-m-Y'),
                    'from' => $formattedFrom,
                    'to' => $formattedTo,
                    'amenity_id' => $booking->amenity_id,
                    'user_id' => $booking->user_id,
                    'mobile' => $booking->mobile,
                    'booking_status' => $booking->booking_status,
                    'status' => $booking->status,
                    'created_at' => $booking->created_at,
                    'updated_at' => $booking->updated_at,
                ];
            });

            return response()->json([
                'status' => true,
                'message' => 'Bookings retrieved successfully.',
                'data' => $bookings
            ]);
        }
        if ($request->has('amenity_id')) {
            $bookings = $query->where('amenity_id', $request->amenity_id)->get();
            $bookings = $bookings->map(function ($booking, $index) {
                $memberName = $booking->first_name . ' ' . $booking->last_name;
                $formattedFrom = \Carbon\Carbon::parse($booking->from)->format('H:i');
                $formattedTo = \Carbon\Carbon::parse($booking->to)->format('H:i');

                return [
                    'id' => $booking->id,
                    'no' => $index + 1,
                    'block_name' => $booking->block_name,
                    'member_name' => $memberName,
                    'day' => \Carbon\Carbon::parse($booking->day)->format('d-m-Y'),
                    'from' => $formattedFrom,
                    'to' => $formattedTo,
                    'amenity_id' => $booking->amenity_id,
                    'user_id' => $booking->user_id,
                    'mobile' => $booking->mobile,
                    'booking_status' => $booking->booking_status,
                    'status' => $booking->status,
                    'created_at' => $booking->created_at,
                    'updated_at' => $booking->updated_at,
                ];
            });

            return response()->json([
                'status' => true,
                'message' => 'Bookings retrieved successfully.',
                'data' => $bookings
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => 'No criteria provided to fetch bookings.',
            'data' => null
        ], 400);
    }

    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:booking_amenities,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation errors.',
                'data' => $validator->errors()
            ], 400);
        }

        $booking = BookingAmenity::find($request->id);
        if (!$booking) {
            return response()->json([
                'status' => false,
                'message' => 'Booking not found.',
                'data' => null
            ], 404);
        }
        $booking->delete();

        return response()->json([
            'status' => true,
            'message' => 'Booking deleted successfully.',
            'data' => null
        ]);
    }
}
