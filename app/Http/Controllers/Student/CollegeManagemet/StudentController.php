<?php

namespace App\Http\Controllers\Student\CollegeManagemet;

use App\Http\Controllers\Controller;
use App\Repositories\ImageRepository;
use App\Repositories\Student\StudentRepository;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    protected $repo;
    protected $img;
    public function __construct(StudentRepository $repo, ImageRepository $img)
    {
        $this->repo = $repo;
        $this->img = $img;
    }





}
