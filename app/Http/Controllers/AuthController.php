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
// use App\Http\Controllers\Controller;
use Illuminate\Routing\Controller;


class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    // Register a new user
    // public function register(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'block_number' => 'required|string|max:50|unique:users',
    //         'first_name' => 'required|string|max:50',
    //         'last_name' => 'required|string|max:50',
    //         'role' => 'required|in:owner,admin,coowner,committee',
    //         'mobile' => 'required|string|max:10|unique:users',
    //         'block' => 'required|string|max:50',
    //         'profile_photo' => 'nullable|string|max:256',
    //         'status' => 'nullable|in:active,inactive',
    //         'email' => 'nullable|email|unique:users',
    //         'password' => 'required|string|min:6',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json($validator->errors(), 422);
    //     }

    //     $user = User::create([
    //         'block_number' => $request->block_number,
    //         'first_name' => $request->first_name,
    //         'last_name' => $request->last_name,
    //         'role' => $request->role,
    //         'mobile' => $request->mobile,
    //         'block' => $request->block,
    //         'profile_photo' => $request->profile_photo,
    //         'status' => $request->status ?? 'active',
    //         'email' => $request->email,
    //         'password' => Hash::make($request->password),
    //     ]);

    //     return response()->json(['message' => 'User registered successfully', 'user' => $user], 201);
    // }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'block_number' => 'required|string|max:50|unique:users',
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'role' => 'required|in:owner,admin,coowner,committee',
            'mobile' => 'required|string|max:10|unique:users',
            'block' => 'required|string|max:50',
            'profile_photo' => 'nullable|image|max:2048', // Ensure it's an image and within size limits
            'status' => 'nullable|in:active,inactive',
            'email' => 'nullable|email|unique:users',
            'password' => 'required|string|min:6',
        ]);
        // dd($validator->errors());
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Handle the file upload for profile photo (if provided)
        $profilePhotoPath = null;
        if ($request->hasFile('profile_photo')) {
            $profilePhotoPath = $request->file('profile_photo')->store('profile_photos', 'public');
        }

        $user = User::create([
            'block_number' => $request->block_number,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'role' => $request->role,
            'mobile' => $request->mobile,
            'block' => $request->block,
            'profile_photo' => $profilePhotoPath,  // Store the path to the image
            'status' => $request->status ?? 'active',
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(["status" => true, 'message' => 'User registered successfully', 'user' => $user], 201);
    }



    /*
    public function login(Request $request)
    {
        // Validate the incoming request
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);


        // Check the credentials
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = JWTAuth::fromUser($user);  // Generate JWT token

            // Build the user details to return in the response
            $userDetails = [
                'fullname' => [
                    'firstname' => $user->first_name,
                    'lastname' => $user->last_name,
                ],
                'email' => $user->email,
                'password' => $user->password,
                'role' => $user->role,
                'id' => $user->id,
            ];

            return response()->json([
                'status' => true,
                'data' => [
                    'token' => $token,
                    'user' => $userDetails
                ]
            ], 200);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }
        */

    public function login(Request $request)
    {
        // Validate the incoming request
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        try {
            // Attempt to authenticate and generate a token
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['message' => 'Invalid email or password'], 401);
            }

            // Retrieve the currently authenticated user using JWTAuth
            $user = JWTAuth::user();

            // Build the user details to return in the response
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
            // Handle token generation errors
            return response()->json(['error' => 'Could not create token'], 500);
        }
    }

    /*
    public function logout(Request $request)
    {

        // Get the authenticated user
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not authenticated'
            ], 401); // Return error if user is not authenticated
        }

        // Log out the user
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
            // Invalidate the token
            JWTAuth::invalidate(JWTAuth::getToken());

            return response()->json([
                'status' => true,
                'message' => 'Logged out successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to logout, please try again'], 500);
        }
    }



    // Step 1: Generate and send OTP to the user's mobile number
    public function otpLogin(Request $request)
    {
        // Validate the mobile number
        $request->validate([
            'mobile' => 'required|regex:/^([0-9]{10})$/', // Validate 10-digit mobile number
            'otp' => 'required|string|size:4', // Validate OTP (4 digits)
        ]);

        $mobile = $request->input('mobile');
        $otp = $request->input('otp');

        // Find the user by mobile number
        $user = User::where('mobile', $mobile)->first();

        if ($user && $user->otp === $otp) {
            // OTP matches, log the user in
            Auth::login($user);

            return response()->json(['message' => 'Login successful'], 200);
        } else {
            return response()->json(['message' => 'Invalid OTP or mobile number'], 401);
        }
    }

    public function sendOtp(Request $request)
    {
        // Validate the incoming mobile number
        $request->validate([
            'mobile' => 'required|regex:/^([0-9]{10})$/', // 10 digits mobile number
        ]);

        // Check if the user exists
        $user = User::where('mobile', $request->mobile)->first();
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Generate OTP and set expiry time (e.g., 5 minutes)
        $otp = rand(1000, 9999);
        $expiry = Carbon::now()->addMinutes(60);

        // Store OTP and expiry in the user table
        $user->otp = $otp;
        $user->otp_expiry = $expiry;
        $user->save();

        // Send OTP to the user's mobile (using an SMS service like Twilio)
        // For now, let's simulate sending OTP with a success message
        // sendOtpToMobile($user->mobile, $otp); // Add your SMS sending logic

        return response()->json(['message' => 'OTP sent to your mobile number']);
    }


    // Step 2: Verify OTP
    // public function verifyOtp(Request $request)
    // {
    //     $request->validate([
    //         'mobile' => 'required|regex:/^([0-9]{10})$/',
    //         'otp' => 'required|numeric|digits:4', // OTP should be 4 digits
    //     ]);

    //     $mobile = $request->input('mobile');
    //     $otp = $request->input('otp');

    //     // Retrieve the user from the database
    //     $user = User::where('mobile', $mobile)->first();

    //     if (!$user) {
    //         return response()->json(['error' => 'User not found.'], 404);
    //     }

    //     // Check if OTP exists and if it has expired
    //     if ($user->otp !== $otp) {
    //         return response()->json(['error' => 'Invalid OTP.'], 400);
    //     }

    //     // Check if OTP has expired
    //     if (Carbon::now()->greaterThan($user->otp_expiry)) {
    //         return response()->json(['error' => 'OTP has expired.'], 400);
    //     }

    //     // OTP is valid, log the user in (or create a user if necessary)
    //     // Assuming you are using Passport, Sanctum, or JWT for authentication
    //     // You can use your desired method to issue the token, here I am using JWT
    //     $token = auth()->login($user);

    //     // Clear OTP after successful login (optional)
    //     $user->otp = null;
    //     $user->otp_expiry = null;
    //     $user->save();

    //     return response()->json(['message' => 'Login successful', 'token' => $token]);
    // }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'mobile' => 'required|regex:/^([0-9]{10})$/',
            'otp' => 'required|numeric|digits:4',
        ]);

        // Retrieve the user
        $user = User::where('mobile', $request->mobile)->first();

        if (!$user) {
            return response()->json(['error' => 'User not found.'], 404);
        }

        // Check if OTP exists and verify it
        if ($user->otp !== $request->otp) {
            return response()->json(['error' => 'Invalid OTP.'], 400);
        }

        // Check if OTP has expired
        if (Carbon::now()->greaterThan($user->otp_expiry)) {
            return response()->json(['error' => 'OTP has expired.'], 400);
        }

        // OTP is valid, log the user in
        $token = auth()->login($user);

        // Clear OTP after successful login for security
        $user->otp = null;
        $user->otp_expiry = null;
        $user->save();

        return response()->json(['message' => 'Login successful', 'token' => $token]);
    }
}
