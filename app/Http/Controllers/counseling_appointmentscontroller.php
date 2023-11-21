<?php

namespace App\Http\Controllers;

use App\Repositories\CounselingAppointmentsRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class counseling_appointmentscontroller extends Controller
{
    protected $repo;
    public function __construct(CounselingAppointmentsRepository $repo)
    {
      $this->repo = $repo;
    }

    public function createCounselingAppointments(Request $req){
        Log::warning($req);
        $counselor_id=$req->input('counselor_id');
        $student_id=$req->input('student_id');
        $course_id=$req->input('course_id');
        $start_time=$req->input('start_time');
        $end_time=$req->input('end_time');
        $notes=$req->input('notes');
        $councelling_date=$req->input('councelling_date');

        return $this->repo->createCounselingAppointments($counselor_id,$student_id,$course_id,$start_time,$end_time, $notes,$councelling_date);

    }
}
