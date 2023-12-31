<?php

namespace App\Http\Controllers\Student\CouncellingManagement;

use App\Http\Controllers\Controller;
use App\Repositories\Student\AvailableSeatsRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AvailableSeatsController extends Controller
{
    
    protected $repo;

    public function __construct(AvailableSeatsRepository $repo)

    {
      $this->repo=$repo;
    
    }

    public function create(Request $req){
        Log::warning($req);
        $course_id=$req->input('course_id');
        $college_id=$req->input('college_id');
        $total_seats=$req->input('total_seats');
        $allocate_seats=$req->input('allocate_seats');
        $year=$req->input('year');
        return $this->repo->create($course_id,$college_id,$total_seats,$allocate_seats,$year);
    }

    public function update(Request $req){
      Log::warning($req);
      $id=$req->input('id');
      $year=$req->input('year');
      $total_seats=$req->input('total_seats');
      $allocate_seats=$req->input('allocate_seats');
      
      return $this->repo->update($id,$year,$total_seats,$allocate_seats);
  }

  public function delete(Request $req){
    Log::warning($req);
    $id=$req->input('id');
    return $this->repo->delete($id);
} 


}
