<?php

use App\Http\Controllers\Staff\StaffManagement\StaffController;
use App\Http\Controllers\Student\Authentication\AuthenticationController;
use App\Http\Controllers\Student\CollegeManagemet\StudentController;
use App\Http\Controllers\Student\CollegeManagemet\CounselorsController;
use App\Http\Controllers\Student\CollegeManagemet\CollegeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});




Route::prefix('student')->group(function (){

Route::post('register',[AuthenticationController::class,'register']);
Route::post('create',[StudentController::class,'createUser']);
Route::post('login',[AuthenticationController::class,'login']);

});



Route::post('create',[CounselorsController::class,'createCounselors']);
Route::post('update',[CounselorsController::class,'updateCounselors']);
Route::post('delete',[CounselorsController::class,'deleteCounselors']);



Route::prefix('college')->group(function (){

    Route::post('create',[CollegeController::class,'create']);
    Route::post('update',[CollegeController::class,'update']);
    Route::post('delete',[CollegeController::class,'delete']);
    Route::get('show',[CollegeController::class,'show']);
    Route::post('status',[CollegeController::class,'status']);
    Route::get('get-college-by-id',[CollegeController::class,'getCollegeById']);




});

Route::post('staff-create',[StaffController::class,'staffCreate']);

Route::post('staff-update',[StaffController::class,'updateStaff']);

Route::post('delete-update',[StaffController::class,'deleteStaff']);

Route::get('show',[StaffController::class,'show']);

Route::post('status',[StaffController::class,'status']);

Route::get('get-staff-by-id',[StaffController::class,'getStaffById']);






