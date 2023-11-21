<?php

namespace App\Repositories\Student;

use Illuminate\Support\Facades\DB;
use Exception;
use App\Models\CounselingAppointments;
use App\Models\Staff;
use App\Repositories\BaseRepositoryInterface;
use Illuminate\Support\Facades\Log;

class CounselingAppointmentsRepository implements BaseRepositoryInterface
{
  public function all()
    {
    }

    public function createCounselingAppointments($counselor_id,$student_id,$course_id,$start_time,$end_time, $notes,$councelling_date)
    {

        DB::beginTransaction();
        try {
            if (!$counselor_id) {
                DB::rollback(); 
                return ["status" => false, "message" => "counselor_id is mandatory"];
            }

          if (!$student_id) {
                DB::rollback(); 
                return ["status" => false, "message" => "$student_id is mandatory"];
            }

          if (!$course_id) {
            DB::rollback(); 
            return ["status" => false, "message" => "$course_id is mandatory"];
         }
      

            if (!$start_time) {
                DB::rollback(); 
                return ["status" => false, "message" => "$start_time is mandatory"];
        }
      

             if (!$end_time) {
               DB::rollback(); 
               return ["status" => false, "message" => "$end_time is mandatory"];
             }

             if (!$$notes) {
              DB::rollback(); 
              return ["status" => false, "message" => "$$notes is mandatory"];
            }

            if (!$councelling_date) {
              DB::rollback(); 
              return ["status" => false, "message" => "$councelling_date is mandatory"];
            }

      $insertQuery = "INSERT INTO Counselors (counselor_id,student_id,course_id,start_time,end_time, notes,councelling_date) VALUES ('$counselor_id','$student_id','$course_id','$start_time','$end_time', '$notes','$councelling_date')";
      $a= DB::select($insertQuery);
     Log::warning($a);
      DB::commit();
      return ["status" => true, "message" => "counseling_appointments added successfully"];
        } catch (Exception $e) {
            Log::warning($e);
            DB::rollBack();
            return ["status" => false, "message" => $e->getMessage()];
        }
          
   
}


}