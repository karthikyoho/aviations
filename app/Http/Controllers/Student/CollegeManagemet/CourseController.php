<?php

namespace App\Http\Controllers\Student\CollegeManagemet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CourseController extends Controller
{
    protected $repo;
    protected $img;
    public function __construct(CoursesCourseRepository $repo, ImageRepository $img)
    {
        $this->repo = $repo;
        $this->img = $img;
    }

    public function createCourses(Request $req)
    {
      Log::warning($req);
      $college_id = $req->input('college_id');
      $department_id = $req->input('department_id');
      $course_id = $req->input('course_id');
      $name = $req->input('name');
      $description = $req->input('description');
      $course_duraton = $req->input('course_duraton');
  
      $imgPath = "assets/Cousrses/images";
      $imagePath = "";
  
  
      if ($req->hasFile('image')) {
        $filePath = $this->img->uploadImage($req->file('image'), $imgPath);
      }
  
  
      $course_duraton = $req->input('course_duraton');
      return $this->repo->createCourses($college_id ,$department_id ,$course_id , $name,$description,$course_duraton,$filePath);
    }
   
    public function update(Request $req)
  { 
    Log::warning($req);

      $id = $req->input('id');
      $name = $req->input('name');
      $description = $req->input('description');

      $imgPath = "assets/Courses/images";
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


