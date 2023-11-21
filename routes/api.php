<?php

use App\Http\Controllers\counseling_appointmentscontroller;
use App\Http\Controllers\Staff\StaffManagement\StaffController;
use App\Http\Controllers\Student\Authentication\AuthenticationController;
use App\Http\Controllers\Student\CouncellingManagement\StudentController;
// use App\Http\Controllers\Student\CouncellingManagement\CounselorsController;
use App\Http\Controllers\Student\CouncellingManagement\CollegeController;
use App\Http\Controllers\Student\CouncellingManagement\CouncellingAppointmentsController;
use App\Http\Controllers\Student\CouncellingManagement\CounselorsController;
use App\Http\Controllers\Student\CouncellingManagement\CourseController;
use App\Http\Controllers\Student\CouncellingManagement\DepartmentController;
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




Route::prefix('users')->group(function (){

Route::post('register',[AuthenticationController::class,'register']);
Route::post('create',[StudentController::class,'createUser']);
Route::post('login',[AuthenticationController::class,'login']);

});

Route::prefix('student')->group(function (){
  Route::post('create',[StudentController::class,'createUser']);
  Route::post('update',[StudentController::class,'updateStudent']);
  Route::post('show',[StudentController::class,'studentShowData']);

});


Route::post('create',[CounselorsController::class,'createCounselors']);
Route::post('update',[CounselorsController::class,'updateCounselors']);
Route::post('delete',[CounselorsController::class,'deleteCounselors']);
Route::get('showall',[CounselorsController::class,'showallCounselors']);
Route::post('listbyid',[CounselorsController::class,'listbyid']);


Route::post('create',[counseling_appointmentscontroller::class,'createCounselingAppointments']);





Route::prefix('college')->group(function (){

    Route::post('create',[CollegeController::class,'create']);
    Route::post('update',[CollegeController::class,'update']);
    Route::post('delete',[CollegeController::class,'delete']);
    Route::get('show',[CollegeController::class,'show']);
    Route::post('status',[CollegeController::class,'status']);
    Route::get('get-college-by-id',[CollegeController::class,'getCollegeById']);




});
Route::prefix('departments')->group(function(){
    Route::post('create',[DepartmentController::class,'createDepartment']);
    Route::post('update',[DepartmentController::class,'updateDepartment']);
    Route::delete('destroy',[DepartmentController::class,'deleteDepartment']);
    Route::get('show',[DepartmentController::class,'getAllDepartment']);
    Route::get('status',[DepartmentController::class,'departmentStatus']);
   
});


Route::prefix('courses')->group(function(){
    Route::post('create',[CourseController::class,'create']);
    Route::post('update',[CourseController::class,'update']);
    Route::post('destroy',[CourseController::class,'delete']);
    Route::get('show',[CourseController::class,'show']);
    Route::post('status',[CourseController::class,'status']);
    Route::get('getCourseById',[CourseController::class,'getCourseById']);

   
});

Route::post('staff-create',[StaffController::class,'staffCreate']);



Route::prefix('appointments')->group(function(){
    Route::get('create',[CouncellingAppointmentsController::class,'createAppointment']);
    Route::get('update',[CouncellingAppointmentsController::class,'updateAppointment']);
    Route::get('delete',[CouncellingAppointmentsController::class,'delete']);
    Route::get('show',[CouncellingAppointmentsController::class,'show']);
    Route::get('get-appointment-by-id',[CouncellingAppointmentsController::class,'getCouncellingAppointmentById']);


});