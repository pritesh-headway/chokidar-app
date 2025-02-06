<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

use Illuminate\Routing\Controller;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'block_number' => 'required|string|max:50|unique:users',
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'role_id' => 'required|in:1,2,3,4',
            'mobile' => 'required|string|max:10|unique:users',
            'block' => 'required|string|max:50',
            'profile_photo' => 'nullable|image',
            'status' => 'nullable|in:active,inactive',
            'email' => 'nullable|email|unique:users',
            'password' => 'required|string|min:6',
            'society_id' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors(),
            ], 422);
        }
        $profilePhotoPath = null;
        if ($request->hasFile('profile_photo')) {

            $file = $request->file('profile_photo');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $destinationPath = public_path('storage/profile_photos');
            $file->move($destinationPath, $fileName);
            $profilePhotoPath = 'profile_photos/' . $fileName;
        }
        $user = User::create([
            'block_number' => $request->block_number,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'role_id' => $request->role_id,
            'mobile' => $request->mobile,
            'block' => $request->block,
            'profile_photo' => $profilePhotoPath,
            'status' => 'inactive',
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'society_id' => $request->society_id,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'User registered successfully',
            'user' => $user,
        ], 201);
    }
    public function login(Request $request)
    {

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        try {

            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['message' => 'Invalid email or password'], 401);
            }
            $user = JWTAuth::user();

            $userDetails = [

                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'role' => $user->role,
                'id' => $user->id,
            ];

            return response()->json([
                'status' => true,
                'message' => "successfully Logged in.",
                'data' => [
                    'token' => $token,
                    'user' => $userDetails,
                ]
            ], 200);
        } catch (JWTException $e) {

            return response()->json(['error' => 'Could not create token'], 500);
        }
    }

    /*
    public function logout(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not authenticated'
            ], 401);
        }
        Auth::logout();

        return response()->json([
            'status' => true,
            'message' => 'Logged out successfully'
        ]);
    }
*/

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        try {

            $token = JWTAuth::getToken();
            if ($token) {
                JWTAuth::invalidate($token);
            }
            auth()->logout();

            return response()->json([
                'status' => true,
                'message' => 'Logged out successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to logout, please try again'], 500);
        }
    }
    public function otpLogin(Request $request)
    {

        $request->validate([
            'mobile' => 'required|regex:/^([0-9]{10})$/',
            'otp' => 'required|string|size:4',
        ]);

        $mobile = $request->input('mobile');
        $otp = $request->input('otp');
        $user = User::where('mobile', $mobile)->first();

        if ($user && $user->otp === $otp) {

            Auth::login($user);

            return response()->json(['message' => 'Login successful'], 200);
        } else {
            return response()->json(['message' => 'Invalid OTP or mobile number'], 401);
        }
    }

    public function sendOtp(Request $request)
    {

        $request->validate([
            'mobile' => 'required|regex:/^([0-9]{10})$/',
        ]);
        $user = User::where('mobile', $request->mobile)->first();
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        $otp = rand(1000, 9999);
        $expiry = Carbon::now()->addMinutes(60);
        $user->otp = $otp;
        $user->otp_expiry = $expiry;
        $user->save();
        return response()->json(['message' => 'OTP sent to your mobile number']);
    }
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'mobile' => 'required|regex:/^([0-9]{10})$/',
            'otp' => 'required|numeric|digits:4',
        ]);
        $user = User::where('mobile', $request->mobile)->first();

        if (!$user) {
            return response()->json(['error' => 'User not found.'], 404);
        }
        if ($user->otp !== $request->otp) {
            return response()->json(['error' => 'Invalid OTP.'], 400);
        }
        if (Carbon::now()->greaterThan($user->otp_expiry)) {
            return response()->json(['error' => 'OTP has expired.'], 400);
        }
        $token = auth()->login($user);
        $user->otp = null;
        $user->otp_expiry = null;
        $user->save();

        return response()->json(['message' => 'Login successful', 'token' => $token]);
    }
}
