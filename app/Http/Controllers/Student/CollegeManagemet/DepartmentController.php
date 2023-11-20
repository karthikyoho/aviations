<?php

namespace App\Http\Controllers\Student\CollegeManagemet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DepartmentController extends Controller
{
    protected $repo;
    protected $img;
    public function __construct(DepartmentCourseRepository $repo, ImageRepository $img)
    {
        $this->repo = $repo;
        $this->img = $img;
    }

    public function createdepartment(Request $req)
    {
      Log::warning($req);
      $college_id = $req->input('college_id');
      $name = $req->input('name');
      $department_id = $req->input('department_id');
      $description = $req->input('description');
  
      $imgPath = "assets/departments/images";
      $filePath = "";
  
  
      if ($req->hasFile('image')) {
        $filePath = $this->img->uploadImage($req->file('image'), $imgPath);
      }
  
  
      return $this->repo->createdepartment($college_id ,$name ,$department_id , $description,$filePath);
    }
   
    public function update(Request $req)
  { 
    Log::warning($req);

      $id = $req->input('id');
      $name = $req->input('name');
      $description = $req->input('description');

      $imgPath = "assets/departments/images";
      $filePath = "";

      if ($req->hasFile('img')) {
        $filePath = $this->img->uploadImage($req->file('img'), $imgPath);
      }
      return $this->repo->update($id,$name,$description,$filePath);
    }
  

  public function delete(Request $req)
  {
    Log::warning($req);
    $id = $req->input('id');
    return $this->repo->delete($id);
  }

 

  public function getAll(Request $req)
  {
    Log::warning($req);
    $search = $req->input('search', '');
    return $this->repo->getAll($search);
  }

   
  public function status(Request $req)
  {
    Log::warning($req);
    $id = $req->input('id');
    $status = $req->input('status');
    return $this->repo->status($id, $status);
  }


  

  public function listById(Request $req)
  {
    Log::warning($req);
    $id = $req->input('id');
    return $this->repo->listById($id);
  }
}
