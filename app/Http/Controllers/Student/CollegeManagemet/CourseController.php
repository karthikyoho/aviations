<?php

namespace App\Http\Controllers\Student\CollegeManagemet;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Repositories\ImageRepository;
use App\Repositories\Student\CourseRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CourseController extends Controller
{
    protected $repo;
    protected $img;
    public function __construct(CourseRepository $repo,ImageRepository $img)
    {
      $this->repo=$repo;
      $this->img=$img;
    }

    public function create(Request $req){
        Log::warning($req);
        $college_id = $req->input('college_id');
        $department_id = $req->input('department_id');
        $name = $req->input('name');
        $description = $req->input('description');
        $course_duraton = $req->input('course_duraton');

        $courseImgPath = "assets/course_management/course/image";
        $filePath = "";
        if ($req->hasFile('image')) {
            $filePath = $this->img->uploadImage($req->file('image'), $courseImgPath);
        }
        return $this->repo->create($college_id,$department_id,$name,$description,$course_duraton,$filePath);
    }

    public function update(Request $req){
        Log::warning($req);
        $id=$req->input('id');
        $college_id = $req->input('college_id');
        $department_id = $req->input('department_id');
        $name = $req->input('name');
        $description = $req->input('description');
        $course_duraton = $req->input('course_duraton');

        $courseImgPath = "assets/course_management/course/image";
        $filePath = "";
        if ($req->hasFile('image')) {
            $filePath = $this->img->uploadImage($req->file('image'), $courseImgPath);
        }
        return $this->repo->update($id,$college_id,$department_id,$name,$description,$course_duraton,$filePath);
    }

}


