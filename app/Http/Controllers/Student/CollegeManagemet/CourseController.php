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
        $course_duration = $req->input('course_duration');
        $total_seats=$req->input('total_seats');
        $available_seats=$req->input('available_seats');


        $courseImgPath = "assets/course_management/course/image";
        $filePath = "";
        if ($req->hasFile('image')) {
            $filePath = $this->img->uploadImage($req->file('image'), $courseImgPath);
        }
        return $this->repo->create($college_id,$department_id,$name,$description,$course_duration,$total_seats,$available_seats,$filePath);
    }

    public function update(Request $req){
        Log::warning($req);
        $id=$req->input('id');
        $name = $req->input('name');
        $description = $req->input('description');
        $course_duration = $req->input('course_duration');
        $total_seats=$req->input('total_seats');
        $available_seats=$req->input('available_seats');

        $courseImgPath = "assets/course_management/course/image";
        $filePath = "";
        if ($req->hasFile('image')) {
            $filePath = $this->img->uploadImage($req->file('image'), $courseImgPath);
        }
        return $this->repo->update($id,$name,$description,$course_duration,$total_seats,$available_seats,$filePath);
    }

            //delete College By id
            public function delete(Request $req){
                Log::warning($req);
                $id=$req->input('id');
            return $this->repo->delete($id);
            }
            
               //display All colleges
            public function show(Request $req){
                Log::warning($req);
                $search=$req->input('search');
            return $this->repo->show($search);
            }
        
                //update College status
            public function status(Request $req ){
                Log::warning($req);
                $id=$req->input('id');
                $status=$req->input('status');
                return $this->repo->status($id,$status);
            }
        
                //display College By Id
            public function getCourseById(Request $req){
                Log::warning($req);
                $id=$req->input('id');
                return $this->repo->getCourseById($id);
            }
         
}


