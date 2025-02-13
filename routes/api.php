<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\HouseController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\AmenityController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SocietyController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\VisitorController;
use App\Http\Controllers\ResponseController;
use App\Http\Controllers\SecurityController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\ComplaintController;

use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\GateDetailController;
use App\Http\Controllers\RoleMemberController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\BookingAmenityController;
use App\Http\Controllers\SubscriptionPlanController;

Route::post('register', [AuthController::class, 'register']);

Route::post('login', [AuthController::class, 'login'])->name('login');

Route::post('otp-login', [AuthController::class, 'otpLogin']);

use App\Http\Controllers\ServiceRequestController;
use App\Http\Controllers\ServiceProviderController;
use App\Http\Controllers\Backend\AllSocietyController;
use App\Http\Controllers\FamilyMemberDetailController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\SuperAdminMiddleware;


// Route::group(['middleware' => ['role:super-admin']], function () {

//     Route::post('/societies-create', [SocietyController::class, 'create']);
//     Route::post('/societies-update', [SocietyController::class, 'update']);
//     Route::post('/societies-delete', [SocietyController::class, 'destroy']);
// });
Route::post('/societyregister', [AllSocietyController::class, 'create'])->name('society.register');
Route::post('contact-us', [ContactUsController::class, 'store']);

// Admin Middleware
Route::middleware(['auth:api', AdminMiddleware::class])->group(function () {
    Route::post('user-create', [UsersController::class, 'store']);
    Route::post('/user-delete', [UsersController::class, 'destroy']);
    Route::post('/user-inactive', [UsersController::class, 'inactiveUsers']);
    Route::post('register-security', [SecurityController::class, 'registerSecurity']);
    Route::post('/amenity-create', [AmenityController::class, 'store']);
    Route::post('/amenity-update', [AmenityController::class, 'update']);
    Route::post('/amenity-delete', [AmenityController::class, 'destroy']);
    Route::post('/amenity-delete-image', [AmenityController::class, 'deleteAmenityImage']);
    Route::post('/booking-delete', [BookingAmenityController::class, 'destroy']);
    Route::post('/notices-create', [NoticeController::class, 'store']);
    Route::post('/notices-update', [NoticeController::class, 'update']);
    Route::post('/notices-delete', [NoticeController::class, 'destroy']);
    Route::post('/maintenance-create', [MaintenanceController::class, 'store']);
    Route::post('/maintenance-delete', [MaintenanceController::class, 'destroy']);
    Route::post('/complaint-delete', [ComplaintController::class, 'destroy']);
    Route::post('/security-update', [SecurityController::class, 'update']);
    Route::post('/security-delete', [SecurityController::class, 'destroy']);
    Route::post('/gate-details-create', [GateDetailController::class, 'store']);
    Route::post('/gate-details-update', [GateDetailController::class, 'update']);
    Route::post('/gate-details-delete', [GateDetailController::class, 'destroy']);
    Route::post('house-delete', [HouseController::class, 'destroy']);
    Route::post('role-create', [DesignationController::class, 'create']);
    Route::post('role-update', [DesignationController::class, 'update']);
    Route::post('role-delete', [DesignationController::class, 'destroy']);
    Route::post('role_members-create', [RoleMemberController::class, 'store']);
    Route::post('role_members-update', [RoleMemberController::class, 'update']);
    Route::post('role_members-delete', [RoleMemberController::class, 'destroy']);
});

// General Middlware
Route::middleware(['auth:api',])->group(function () {

    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('/user-read', [UsersController::class, 'index']);
    // Route::post('user-create', [UsersController::class, 'store']); // only admins
    Route::post('/user-update', [UsersController::class, 'update']);
    // Route::post('/user-delete', [UsersController::class, 'destroy']); // only admins
    // Route::post('/user-inactive', [UsersController::class, 'inactiveUsers']); // only admins
    Route::post('/family-read', [FamilyMemberDetailController::class, 'read']);
    Route::post('/family-create', [FamilyMemberDetailController::class, 'store']);
    Route::post('/family-update', [FamilyMemberDetailController::class, 'update']);
    Route::post('/family-delete', [FamilyMemberDetailController::class, 'destroy']);

    // Route::post('register-security', [SecurityController::class, 'registerSecurity']); // only admins
    Route::post('vehicle-read', [VehicleController::class, 'index']);
    Route::post('vehicle-create', [VehicleController::class, 'store']);
    Route::post('vehicle-update', [VehicleController::class, 'update']);
    Route::post('vehicle-delete', [VehicleController::class, 'destroy']);
    Route::post('/visitor-read', [VisitorController::class, 'index']);
    Route::post('/visitor-create', [VisitorController::class, 'store']);
    Route::post('/visitor-update', [VisitorController::class, 'update']);
    Route::post('/visitor-delete', [VisitorController::class, 'destroy']);
    Route::post('/amenity', [AmenityController::class, 'index']);
    // Route::post('/amenity-create', [AmenityController::class, 'store']); // only admins
    Route::post('/amenity-show', [AmenityController::class, 'show']);
    // Route::post('/amenity-update', [AmenityController::class, 'update']); // only admins
    // Route::post('/amenity-delete', [AmenityController::class, 'destroy']); // only admins
    // Route::post('/amenity-delete-image', [AmenityController::class, 'deleteAmenityImage']); // only admins
    Route::post('/booking', [BookingAmenityController::class, 'index']);
    Route::post('/booking-create', [BookingAmenityController::class, 'store']);
    Route::post('/booking-show', [BookingAmenityController::class, 'show']);
    Route::post('/booking-update', [BookingAmenityController::class, 'update']);
    // Route::post('/booking-delete', [BookingAmenityController::class, 'destroy']); // only admins

    Route::post('/user-role', [UserRoleController::class, 'store']); // ???
    Route::put('/user-role/{id}', [UserRoleController::class, 'update']);
    Route::delete('/user-role/{id}', [UserRoleController::class, 'destroy']);
    // Route::post('/notices-create', [NoticeController::class, 'store']); // only admins
    Route::post('/notices', [NoticeController::class, 'index']);
    Route::post('/notices-show', [NoticeController::class, 'show']);
    // Route::post('/notices-update', [NoticeController::class, 'update']); // only admins
    // Route::post('/notices-delete', [NoticeController::class, 'destroy']); // only admins
    Route::post('/maintenance', [MaintenanceController::class, 'index']);
    Route::post('/maintenance-show', [MaintenanceController::class, 'show']);
    // Route::post('/maintenance-create', [MaintenanceController::class, 'store']); // only admins
    Route::post('/maintenance-update', [MaintenanceController::class, 'update']);
    // Route::post('/maintenance-delete', [MaintenanceController::class, 'destroy']); // only admins
    Route::post('/complaint', [ComplaintController::class, 'index']);
    Route::post('/complaint-show', [ComplaintController::class, 'show']);
    Route::post('/complaint-create', [ComplaintController::class, 'store']);
    Route::post('/complaint-update', [ComplaintController::class, 'update']);
    // Route::post('/complaint-delete', [ComplaintController::class, 'destroy']); // only admins
    Route::post('/security', [SecurityController::class, 'index']);
    Route::post('/security-show', [SecurityController::class, 'show']);
    // Route::post('/security-create', [SecurityController::class, 'store']);
    // Route::post('/security-update', [SecurityController::class, 'update']); // only admins
    // Route::post('/security-delete', [SecurityController::class, 'destroy']); // only admins
    // Route::post('/gate-details-create', [GateDetailController::class, 'store']); // only admins
    Route::post('/gate-details', [GateDetailController::class, 'index']);
    Route::post('/gate-details-show', [GateDetailController::class, 'show']);
    // Route::post('/gate-details-update', [GateDetailController::class, 'update']); // only admins
    // Route::post('/gate-details-delete', [GateDetailController::class, 'destroy']); // only admins
    Route::post('/gate-details-gate-no', [GateDetailController::class, 'getByGateNo']);
    Route::post('/forums', [ForumController::class, 'getAllActiveForums']);
    Route::post('/forums-show', [ForumController::class, 'show']);
    Route::post('/forums-create', [ForumController::class, 'store']);
    Route::post('/forums-update', [ForumController::class, 'update']);
    Route::post('/forums-delete', [ForumController::class, 'destroy']);
    Route::post('/forums-allinactive', [ForumController::class, 'getAllInactiveForums']);
    Route::post('/forums-allactive', [ForumController::class, 'getAllactiveForums']);
    Route::post('responses', [ResponseController::class, 'index']);
    Route::post('responses-show', [ResponseController::class, 'show']);
    Route::post('responses-create', [ResponseController::class, 'store']);
    Route::post('responses-update', [ResponseController::class, 'update']);
    Route::post('responses-delete', [ResponseController::class, 'delete']);
    Route::post('conversations', [ConversationController::class, 'index']);
    Route::post('conversations-show', [ConversationController::class, 'show']);
    Route::post('conversations-create', [ConversationController::class, 'store']);
    Route::post('conversations-update', [ConversationController::class, 'update']);
    Route::post('conversations-delete', [ConversationController::class, 'destroy']);
    Route::post('messages', [MessageController::class, 'index']);
    Route::post('messages-show', [MessageController::class, 'show']);
    Route::post('messages-create', [MessageController::class, 'store']);
    Route::post('messages-update', [MessageController::class, 'update']);
    Route::post('messages-delete', [MessageController::class, 'destroy']);
    Route::post('/societies', [SocietyController::class, 'index']);
    Route::post('/societies-show', [SocietyController::class, 'show']);
    Route::post('house-create', [HouseController::class, 'store']);
    Route::post('house', [HouseController::class, 'index']);
    Route::post('house-show', [HouseController::class, 'show']);
    Route::post('house-update', [HouseController::class, 'update']);
    // Route::post('house-delete', [HouseController::class, 'destroy']); // only admins
    // Route::post('role-create', [DesignationController::class, 'create']); // only admins
    Route::post('role', [DesignationController::class, 'index']);
    Route::post('role-show', [DesignationController::class, 'show']);
    // Route::post('role-update', [DesignationController::class, 'update']); // only admins
    // Route::post('role-delete', [DesignationController::class, 'destroy']); // only admins
    // Route::post('role_members-create', [RoleMemberController::class, 'store']); // only admins
    Route::post('role_members', [RoleMemberController::class, 'index']);
    Route::post('role_members-show', [RoleMemberController::class, 'show']);
    // Route::post('role_members-update', [RoleMemberController::class, 'update']); // only admins
    // Route::post('role_members-delete', [RoleMemberController::class, 'destroy']); // only admins
    Route::post('services-create', [ServiceController::class, 'store']);
    Route::post('services', [ServiceController::class, 'index']);
    Route::post('services-update', [ServiceController::class, 'update']);
    Route::post('services-show', [ServiceController::class, 'show']);
    Route::post('services-delete', [ServiceController::class, 'destroy']);
    Route::post('service_providers-create', [ServiceProviderController::class, 'store']); // ?????
    Route::post('service_providers', [ServiceProviderController::class, 'index']);
    Route::post('service_providers-show', [ServiceProviderController::class, 'show']);
    Route::post('service_providers-update', [ServiceProviderController::class, 'update']);
    Route::post('service_providers-delete', [ServiceProviderController::class, 'destroy']);
    Route::post('service_providers-bytype', [ServiceProviderController::class, 'getByServiceType']);
    Route::post('service_requests', [ServiceRequestController::class, 'index']);
    Route::post('service_requests-update', [ServiceRequestController::class, 'update']);
    Route::post('service_requests-create', [ServiceRequestController::class, 'store']);
    Route::post('service_requests-show', [ServiceRequestController::class, 'show']);
    Route::post('service_requests-delete', [ServiceRequestController::class, 'destroy']);
    Route::post('get_all_personal_services', [ServiceRequestController::class, 'getServiceRequestsByMemberId']);


    // Subscription plan

    Route::post('subscription-plan', [SubscriptionPlanController::class, 'index']);
    Route::post('subscription-plan-show', [SubscriptionPlanController::class, 'show']);
});
Route::middleware(['auth:api', SuperAdminMiddleware::class])->group(function () {
    Route::post('subscription-plan-update', [SubscriptionPlanController::class, 'update']);
    Route::post('subscription-plan-create', [SubscriptionPlanController::class, 'store']);
    Route::post('subscription-plan-delete', [SubscriptionPlanController::class, 'destroy']);



    Route::post('/payments/store', [PaymentController::class, 'store']);
    Route::post('/payments/update', [PaymentController::class, 'update']);
    Route::post('/payments/show', [PaymentController::class, 'show']);
    Route::post('/payments/delete', [PaymentController::class, 'delete']);
});

Route::get('test', function () {
    return response()->json(['message' => 'CORS is working!']);
});
