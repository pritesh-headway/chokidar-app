<?php

namespace App\Http\Controllers;

use App\Models\ContactUs;
use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\ContactUsNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use App\Mail\ContactUsSubmitted;
use Illuminate\Support\Facades\Mail;

class ContactUsController extends Controller
{
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'society_name' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'nullable|digits:10',
            'comments' => 'required|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $contactUs = ContactUs::create([
            'society_name' => $request->society_name,
            'country' => $request->country,
            'city' => $request->city,
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'comments' => $request->comments,
        ]);

        Mail::to('durgesh.hirani@headway.org.in')->send(new ContactUsSubmitted($contactUs));
        $admin = User::where('role_id', 1)->first();
        Notification::send($admin, new ContactUsNotification($contactUs->toArray()));

        return response()->json(['status' => true, 'message' => 'Contact submitted successfully!', 'data' => $contactUs], 201);
    }
}
