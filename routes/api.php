<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GeneralSettingController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\ModulesController;
use App\Http\Controllers\SystemSettingController;
use App\Http\Controllers\ScreenModuleController;
use App\Http\Controllers\StaffManagementController;
use App\Http\Controllers\ForgetpasswordController;
use App\Http\Controllers\DefaultRoleAccessController;

/*
|--------------------------------------------------------------------------
|  Secured API Routes
|--------------------------------------------------------------------------
|
*/
// -------------------- Auth Routes --------------------
Route::group(['prefix' => 'auth', 'middleware' => 'api'], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
});

// -------------------- User Routes (Requires JWT Authentication) --------------------
Route::group(['middleware' => ['jwt.verify']], function () {
    Route::get('/users/{from}/{to}', [UsersController::class, 'user_list']);           // Fetch list of users with date range
    Route::get('/user-profile', [AuthController::class, 'userProfile']);               // Get user profile
    Route::post('/allowed-modules', [UsersController::class, 'get_user_role']);        // Get allowed modules based on role
});

// -------------------- Role Management Routes --------------------
Route::group(['prefix' => 'roles','middleware' => 'apiInternal'], function () {
    Route::get('/list', [RolesController::class, 'index']);                           // Get list of roles
    Route::get('/screenaccessroleslist', [RolesController::class, 'screenaccessroleslist']); // Get screen access roles list
    Route::get('/branch-viewlist', [RolesController::class, 'branch_view_list']);      // Get branch view list
    Route::get('/system-admin-role', [RolesController::class, 'system_admin_role']);   // Get system admin role
    Route::post('/add', [RolesController::class, 'store']);                           // Add a new role
    Route::post('/update', [RolesController::class, 'update']);                        // Update a role
    Route::post('/remove', [RolesController::class, 'delete']);                     // Remove a role
    Route::post('/assign', [RolesController::class, 'set_role']);                     // Assign role to user
    Route::post('/role-byId', [RolesController::class, 'role_byId']);                 // Get role by ID
});

// -------------------- Module Management Routes --------------------
Route::group(['prefix' => 'modules','middleware' => 'apiInternal'], function () {
    Route::get('/list', [ModulesController::class, 'index']);                         // Get list of modules
    Route::post('/add', [ModulesController::class, 'store']);                         // Add a new module
    Route::post('/update', [ModulesController::class, 'update']);                      // Update a module
    Route::post('/remove', [ModulesController::class, 'delete']);                   // Remove a module
    Route::get('/get-child/{type}', [ModulesController::class, 'get_child_from_type']); // Get child modules by type
});

// -------------------- Default Role Access Routes --------------------
Route::group(['prefix' => 'default-role-access','middleware' => 'apiInternal'], function () {
    Route::post('/add', [DefaultRoleAccessController::class, 'store']);               // Add default role access
    Route::post('/listbyId', [DefaultRoleAccessController::class, 'listbyId']);       // Get default role access by ID
    Route::post('/{id}/delete', [DefaultRoleAccessController::class, 'delete']);    // Delete default role access
});

// -------------------- Staff Management Routes --------------------
Route::group(['prefix' => 'staff-record','middleware' => ['jwt.verify']], function () {
    Route::get('/getStaffList', [StaffManagementController::class, 'getStaffList']);  // Get list of staff
    Route::get('/getStaffListByCode/{code}', [StaffManagementController::class, 'getStaffListByCode']); // Get staff by code
    Route::get('/getStaffListById/{id}', [StaffManagementController::class, 'getStaffListById']); // Get staff by ID (changed to GET)
    Route::post('/createNewStaff', [StaffManagementController::class, 'createNewStaff']); // Create new staff
    Route::get('/isExistNric/{nric}', [StaffManagementController::class, 'isExistNric']); // Check if NRIC exists (changed to GET)
    Route::post('/deleteStaff/{id}', [StaffManagementController::class, 'deleteStaff']); // Delete staff by ID (changed to DELETE)
});

// -------------------- Access Management Routes --------------------
Route::group(['prefix' => 'access','middleware' => 'apiInternal'], function () {
    Route::post('/sidebar', [ScreenModuleController::class, 'getAccessScreenByUserId']); // Get sidebar access by user ID
});

// -------------------- Screen Module Routes --------------------
Route::group(['prefix' => 'screen-module','middleware' => 'apiInternal'], function () {
    Route::post('/add', [ScreenModuleController::class, 'storeModule']);             // Add screen module
    Route::post('/add-sub-module', [ScreenModuleController::class, 'storeSubModule']); // Add sub-module
    Route::post('/add-screen-page', [ScreenModuleController::class, 'storeScreen']);   // Add screen page
    Route::get('/list', [ScreenModuleController::class, 'getModuleList']);           // Get module list
    Route::get('/sub-module-list', [ScreenModuleController::class, 'getSubModuleList']); // Get sub-module list
    Route::post('/sub-module-list-by-module-id', [ScreenModuleController::class, 'getSubModuleListByModuleId']); // Get sub-module list by module ID
    Route::post('/sub-module-list-by-sub-module-id', [ScreenModuleController::class, 'getSubModuleListBySubModuleId']); // Get sub-module list by sub-module ID
    Route::post('/get-screen', [ScreenModuleController::class, 'getScreenByModuleAndSubModule']); // Get screen by module and sub-module
    Route::post('/assign-screen', [ScreenModuleController::class, 'addScreenRoles']); // Assign screen roles
    Route::post('/module-list-by-module-id', [ScreenModuleController::class, 'getModuleListByModuleId']); // Get module list by module ID
    Route::post('/updateModule', [ScreenModuleController::class, 'updateModule']);   // Update module 
    Route::post('/removeModule/{id}', [ScreenModuleController::class, 'removeModule']); // Remove module by ID (changed to DELETE)
    Route::post('/updateSubModule', [ScreenModuleController::class, 'updateSubModule']);  // Update sub-module 
    Route::post('/removeSubModule/{id}', [ScreenModuleController::class, 'removeSubModule']); // Remove sub-module by ID (changed to DELETE)
    Route::get('/getScreenPageList', [ScreenModuleController::class, 'getScreenPageList']); // Get screen page list
    Route::get('/getScreenModuleListById', [ScreenModuleController::class, 'getScreenModuleListById']); // Get screen module list by ID
    Route::post('/updateScreenModule', [ScreenModuleController::class, 'updateScreenModule']); // Update screen module 
    Route::post('/removeScreenModule/{id}', [ScreenModuleController::class, 'removeScreenModule']); // Remove screen module by ID (changed to DELETE)
    Route::post('/getScreenPageListByModuleIdAndSubModuleId', [ScreenModuleController::class, 'getScreenPageListByModuleIdAndSubModuleId']); // Get screen page list by module ID and sub-module ID
    Route::get('/getUserMatrixList', [ScreenModuleController::class, 'getUserMatrixList']); // Get user matrix list
    Route::post('/getUserMatrixListById', [ScreenModuleController::class, 'getUserMatrixListById']); // Get user matrix list by ID
    Route::post('/updatescreenRole', [ScreenModuleController::class, 'UpdateScreenRole']); // Update screen role 
    Route::post('/getScreenByModuleId', [ScreenModuleController::class, 'getScreenByModuleId']); // Get screen by module ID
    Route::post('/assign-screen-byRoleId', [ScreenModuleController::class, 'addScreenByRolesId']); // Assign screen by role ID
});

// -------------------- System Settings Routes --------------------
Route::group(['prefix' => 'system-settings','middleware' => 'apiInternal'], function () {
    Route::post('/insertOrupdate', [SystemSettingController::class, 'store']);        // Insert or update system setting
    Route::get('/get-setting/{section}', [SystemSettingController::class, 'get_setting']); // Get system setting by section
});

// -------------------- General Settings Routes --------------------
Route::group(['prefix' => 'general-setting','middleware' => 'apiInternal'], function () {
    Route::post('/add', [GeneralSettingController::class, 'add']);                   // Add a general setting
    Route::get('/lists', [GeneralSettingController::class, 'getListSetting']);       // Get list of general settings
    Route::post('/update', [GeneralSettingController::class, 'update']);              // Update a general setting 
    Route::post('/remove/{id}', [GeneralSettingController::class, 'remove']);      // Remove a general setting by ID (changed to DELETE)
});

/*
|--------------------------------------------------------------------------
|  Public API Routes
|--------------------------------------------------------------------------
|
*/
// -------------------- Password Routes --------------------
Route::group(['prefix' => 'pass','middleware' => 'apiPublic'], function () {
    Route::post('/forgetpass', [ForgetpasswordController::class, 'forgetpass']);
});


/*
|--------------------------------------------------------------------------
|  Fallback API Routes
|--------------------------------------------------------------------------
|
*/
Route::fallback(function () {
    return response()->json([
        'message' => 'Error: API route not found or invalid access.'
    ], 404);
});