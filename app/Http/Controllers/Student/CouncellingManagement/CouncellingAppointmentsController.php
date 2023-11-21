<?php

namespace App\Http\Controllers\Student\CouncellingManagement;

use App\Http\Controllers\Controller;
use App\Repositories\CounselingAppointmentsRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CouncellingAppointmentsController extends Controller
{
    protected $repo;
    protected $img;
public function __construct(CounselingAppointmentsRepository $repo){
    $this->repo=$repo;

}
public function createAppointment(Request $req)
{
    $validator=Validator::make([
        'counselor_id' => 'required|exists:counselors,id',
        'student_id' => 'required|exists:students,id',
        'course_id' => 'required|exists:courses,id',
        'start_time' => 'required|date_format:Y-m-d H:i:s',
        'end_time' => 'required|date_format:Y-m-d H:i:s|after:start_time',
        'notes' => 'nullable|string',
        'counseling_date' => 'required|date_format:Y-m-d H:i:s',
    
    ]);
    if($validator->fails()){
        return ['status'=>false,'message'=>$validator->fails()];
    }
    return $this->repo->createAppointment($req->all());
    
}
public function updateAppointment(Request $req){  
{
    Log::warning($req);
    $data = $req->all();   
    return $this->repo->updateAppointment($req->all());
    
}
}
public function delete(Request $req){
        $id=$req->input('id');
        return $this->repo->delete($id);
}

public function show(){
    return $this->repo->show();
}

public function getCouncellingAppointmentById(Request $req){
    $id=$req->input('id');
    return $this->repo->getCouncellingAppointmentById($id);
}
}
   
