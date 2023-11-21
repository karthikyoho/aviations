<?php

use App\Http\Controllers\Student\Authentication\AuthenticationController;
use App\Http\Controllers\Student\CollegeManagemet\CollegeController;
use App\Http\Controllers\Student\CollegeManagemet\DepartmentController;
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


Route::post('register',[AuthenticationController::class,'register']);

Route::prefix('college')->group(function (){

    Route::post('create',[CollegeController::class,'create']);
    Route::post('update',[CollegeController::class,'update']);
    Route::post('delete',[CollegeController::class,'delete']);



});
Route::prefix('departments')->group(function(){
    Route::post('create',[DepartmentController::class,'createDepartment']);
    Route::post('update',[DepartmentController::class,'updateDepartment']);
    Route::delete('destroy',[DepartmentController::class,'deleteDepartment']);
    Route::get('show',[DepartmentController::class,'getAllDepartment']);
    Route::get('status',[DepartmentController::class,'departmentStatus']);
   
});

