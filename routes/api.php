<?php
//  php artisan serve --host=192.168.1.12 --port=8000
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
// use App\Http\Controllers\ChokidarController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\AmenityController;
use App\Http\Controllers\BookingAmenityController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\VisitorController;
use App\Http\Controllers\ResponseController;
use App\Http\Controllers\SecurityController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\FamilyMemberDetailController;


//
// "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMTkyLjE2OC4xLjEyOjgwMDAvYXBpL2xvZ2luIiwiaWF0IjoxNzM2MzE3ODg1LCJleHAiOjE3MzYzMjE0ODUsIm5iZiI6MTczNjMxNzg4NSwianRpIjoiT2NQWU0wUW9icG9rM3R5ZyIsInN1YiI6IjEiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.QbJ6q-mC3TT13r0s6UHfb6Pb-eFEAF-WgxUqzb-H1eQ"
// jwt-auth secret ukiezDev8FnMFUky4o2re9xICNjqWONgX6ycaXA1HXocwGnYDQ3t2akZfBMhtNs8
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login'])->name('login');
// Route::post('logout', [AuthController::class, 'logout']);
Route::post('otp-login', [AuthController::class, 'otpLogin']);

// Route::post('login', [AuthController::class, 'login']);
// Route::post('register', [AuthController::class, 'register']);
// Route::post('logout', [AuthController::class, 'logout']);

// Middleware-protected user route
// Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
//     return $request->user();
// });



// Route::middleware(['auth'])->group(function () {
// });

// Route::get('/vehicles', [VehicleController::class, 'getVehiclesByUserId']);

Route::middleware(['auth:api'])->group(function () {

    Route::post('logout', [AuthController::class, 'logout']);

    // Route::get('/user', [UsersController::class, 'index']);
    // Route::post('/user', [UsersController::class, 'store']);  // Create user
    // Route::post('/user/{id}', [UsersController::class, 'update']);  // Update user
    // Route::delete('/user/{id}', [UsersController::class, 'destroy']);

    Route::post('/user-read', [UsersController::class, 'index']);  // Get all users or a specific user
    Route::post('/user-create', [UsersController::class, 'store']);  // Create a user
    Route::post('/user-update', [UsersController::class, 'update']);  // Update a user
    Route::post('/user-delete', [UsersController::class, 'destroy']);  // Delete a user


    // Route::get('/family', [FamilyMemberDetailController::class, 'index']);
    // Route::get('/family/{id}', [FamilyMemberDetailController::class, 'show']);
    // Route::post('/family', [FamilyMemberDetailController::class, 'store']);
    // Route::post('/family/{id}', [FamilyMemberDetailController::class, 'update']);
    // Route::delete('/family/{id}', [FamilyMemberDetailController::class, 'destroy']);
    Route::post('/family-read', [FamilyMemberDetailController::class, 'read']);
    Route::post('/family-create', [FamilyMemberDetailController::class, 'store']);
    Route::post('/family-update', [FamilyMemberDetailController::class, 'update']);
    Route::post('/family-delete', [FamilyMemberDetailController::class, 'destroy']);


    // // Vehicle CRUD routes
    // Route::prefix('vehicles')->group(function () {
    //     Route::get('/', [VehicleController::class, 'getVehiclesByUserId']);  // List all vehicles or vehicles by user ID
    //     Route::get('/{id}', [VehicleController::class, 'show']);             // Get a specific vehicle by ID
    //     Route::post('/', [VehicleController::class, 'store']);               // Create a new vehicle
    //     Route::post('/{id}', [VehicleController::class, 'update']);          // Update an existing vehicle by ID
    //     Route::delete('/{id}', [VehicleController::class, 'destroy']);       // Delete a vehicle by ID
    // });

    // Vehicle CRUD routes

    Route::post('vehicle-read', [VehicleController::class, 'index']); // Fetch vehicles by user_id
    Route::post('vehicle-create', [VehicleController::class, 'store']);         // Create a new vehicle
    Route::post('vehicle-update', [VehicleController::class, 'update']);        // Update an existing vehicle
    Route::post('vehicle-delete', [VehicleController::class, 'destroy']);       // Delete a vehicle


    // Route::get('/visitors', [VisitorController::class, 'index']);  // Get visitors for a specific user
    // Route::post('/visitors', [VisitorController::class, 'store']);  // Store a new visitor
    // Route::post('/visitors/{id}', [VisitorController::class, 'update']);  // Update user
    // Route::delete('/visitors/{id}', [VisitorController::class, 'destroy']);
    Route::post('/visitor-read', [VisitorController::class, 'index']);  // Fetch visitors
    Route::post('/visitor-create', [VisitorController::class, 'store']);  // Store a new visitor
    Route::post('/visitor-update', [VisitorController::class, 'update']);  // Update visitor
    Route::post('/visitor-delete', [VisitorController::class, 'destroy']);  // Delete visitor


    Route::post('/amenity', [AmenityController::class, 'index']);
    Route::post('/amenity-create', [AmenityController::class, 'store']);
    Route::post('/amenity-show', [AmenityController::class, 'show']);
    Route::post('/amenity-update', [AmenityController::class, 'update']);
    Route::post('/amenity-delete', [AmenityController::class, 'destroy']);


    Route::post('/booking', [BookingAmenityController::class, 'index']);
    Route::post('/booking-create', [BookingAmenityController::class, 'store']);
    Route::post('/booking-show', [BookingAmenityController::class, 'show']);
    Route::post('/booking-update', [BookingAmenityController::class, 'update']);
    Route::post('/booking-delete', [BookingAmenityController::class, 'destroy']);



    Route::post('/notices', [NoticeController::class, 'store']);
    Route::get('/notices', [NoticeController::class, 'index']);
    Route::get('/notices/{id}', [NoticeController::class, 'show']);
    Route::post('/notices/{id}', [NoticeController::class, 'update']);
    Route::delete('/notices/{id}', [NoticeController::class, 'destroy']);


    // Maintenance CRUD
    // Route::get('/maintenance', [MaintenanceController::class, 'index']); // Fetch all or user-specific maintenance records
    // Route::get('/maintenance/{id}', [MaintenanceController::class, 'show']); // Fetch a specific maintenance record by ID
    // Route::post('/maintenance', [MaintenanceController::class, 'store']); // Create a new maintenance record
    // Route::post('/maintenance/{id}', [MaintenanceController::class, 'update']); // Update a maintenance record by ID
    // Route::delete('/maintenance/{id}', [MaintenanceController::class, 'destroy']); // Delete a maintenance record by ID

    // Maintenance CRUD (all POST)
    Route::post('/maintenance', [MaintenanceController::class, 'index']);  // Fetch all or user-specific maintenance records
    Route::post('/maintenance-show', [MaintenanceController::class, 'show']);    // Fetch a specific maintenance record
    Route::post('/maintenance-create', [MaintenanceController::class, 'store']);   // Create a new maintenance record
    Route::post('/maintenance-update', [MaintenanceController::class, 'update']); // Update a maintenance record
    Route::post('/maintenance-delete', [MaintenanceController::class, 'destroy']); // Delete a maintenance record


    // // Retrieve all complaints or complaints for a specific user
    // Route::get('/complaint', [ComplaintController::class, 'index']);  // Read complaints for user
    // Route::get('/complaint/{id}', [ComplaintController::class, 'show']);  // Retrieve a specific complaint
    // Route::post('/complaint', [ComplaintController::class, 'store']);  // Create complaint
    // Route::post('/complaint/{id}', [ComplaintController::class, 'update']);  // Update complaint
    // Route::delete('/complaint/{id}', [ComplaintController::class, 'destroy']);  // Delete complaint
    // Modify routes to only allow POST and remove GET and DELETE
    Route::post('/complaint', [ComplaintController::class, 'index']);  // Retrieve complaints
    Route::post('/complaint-show', [ComplaintController::class, 'show']);  // Retrieve a specific complaint
    Route::post('/complaint-create', [ComplaintController::class, 'store']);  // Create complaint
    Route::post('/complaint-update', [ComplaintController::class, 'update']);  // Update complaint
    Route::post('/complaint-delete', [ComplaintController::class, 'destroy']);  // Delete complaint


    Route::get('/security', [SecurityController::class, 'index']);
    Route::get('/security/{id}', [SecurityController::class, 'show']);
    Route::post('/security', [SecurityController::class, 'store']);
    Route::post('/security/{id}', [SecurityController::class, 'update']);
    Route::delete('/security/{id}', [SecurityController::class, 'destroy']);


    Route::get('/forums', [ForumController::class, 'index']);
    Route::get('/forums/{id}', [ForumController::class, 'show']);
    Route::post('/forums', [ForumController::class, 'store']);
    Route::post('/forums/{id}', [ForumController::class, 'update']);
    Route::delete('/forums/{id}', [ForumController::class, 'destroy']);


    Route::get('/responses', [ResponseController::class, 'index']);
    Route::get('/responses/{id}', [ResponseController::class, 'show']);
    Route::post('/responses', [ResponseController::class, 'store']);
    Route::post('/responses/{id}', [ResponseController::class, 'update']);
    Route::delete('/responses/{id}', [ResponseController::class, 'destroy']);
});

Route::get('/test', function () {
    return response()->json(['message' => 'CORS is working!']);
});


//Route::get('/complaint', [ComplaintController::class, 'index']);  // Get visitors for a specific user
// Route::post('/complaint', [ComplaintController::class, 'store']);
// Route::get('/complaint', [ComplaintController::class, 'index']);  // Read complaints for user
// Route::post('/complaint', [ComplaintController::class, 'store']);  // Create complaint
// Route::post('/complaint/{id}', [ComplaintController::class, 'update']);  // Update complaint
// Route::delete('/complaint/{id}', [ComplaintController::class, 'destroy']);  // Delete complaint
// Public API routes
// Route::post('/register', [UsersController::class, 'register']);
// Route::post('/login', [UsersController::class, 'login']);
// Route::post('/login', [AuthController::class, 'login']);




// Route::post('/logout', [UsersController::class, 'logout'])->middleware('auth:sanctum');

// // Chokidar-specific routes
// Route::middleware(['auth:sanctum'])->group(function () {
//     Route::get('/chokidar', [ChokidarController::class, 'index']); // Fetch all chokidar records
//     Route::post('/chokidar', [ChokidarController::class, 'store']); // Create a new chokidar entry
//     Route::get('/chokidar/{id}', [ChokidarController::class, 'show']); // Fetch single chokidar record
//     Route::put('/chokidar/{id}', [ChokidarController::class, 'update']); // Update chokidar record
//     Route::delete('/chokidar/{id}', [ChokidarController::class, 'destroy']); // Delete chokidar record
// });
