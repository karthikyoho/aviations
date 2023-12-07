<?php

namespace App\Http\Controllers\Student\CouncellingManagement;

use App\Http\Controllers\Controller;
use App\Repositories\ImageRepository;
use App\Repositories\Student\DepartmentRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends Controller
{
  protected $course;
  protected $img;
  public function __construct(DepartmentRepository $course, ImageRepository $img)
  {
    $this->course = $course;
    $this->img = $img;
  }

  public function createDepartment(Request $req)
  {
    Log::warning($req);

    $validator = Validator::make($req->all(), [
      'college_id' => 'required',
      'name' => 'required|unique:departments',
      'description' => 'required',
    ]);

    $imgPath = "assets/departments/images";
    $filePath = "";

    if ($req->hasFile('image')) {
      $filePath = $this->img->uploadImage($req->file('image'), $imgPath);
    }

    if ($validator->fails()) {
      return ['status' => false, 'message' => 'Validation fails'];
    }

    return $this->course->createDepartment($req->all(), $filePath);
  }

  public function updateDepartment(Request $request)
  {
    Log::warning($request);
    $data = $request->all();
    $InstituteImgPath = "assets/departments/image";
    $filePath = "";
    if ($request->hasFile('image')) {
      $filePath = $this->img->uploadImage($request->file('image'), $InstituteImgPath);
    }
    return $this->course->updateDepartment($request->all(), $filePath);
  }


  public function deleteDepartment(Request $req)
  {

    Log::warning($req);

    $id = $req->input('id');

    return  $this->course->deleteDepartment($id);
    
  }


  public function getAllDepartment(Request $req)
  {
    Log::warning($req);
    $search = $req->input('search', '');
    return $this->course->getAllDepartment($search);
  }


  public function departmentStatus(Request $req)
  {
    // Validate input
    $validator = Validator::make($req->all(), [
      'id' => 'required',
      'status' => 'required|in:yes,no',
    ]);

    if ($validator->fails()) {
      return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
    }

    return $this->course->departmentStatus($req->input('id'), $req->input('status'));
  }
}
