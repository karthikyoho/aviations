<?php

namespace App\Repositories;

use App\Models\Counselors;
use App\Models\Student;
use App\Models\User;
use App\Repositories\BaseRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CounselorsRepository implements BaseRepositoryInterface
{
public function all()

{
}

public function createCounselors($name,$staff_id,$email,$phone,$office_location)
{
    DB::beginTransaction();
    try {
        if (!$name) {
            DB::rollback(); 
            return ["status" => false, "message" => "name is mandatory"];
        }
        if (!$staff_id) {
            DB::rollback(); 
            return ["status" => false, "message" => "staff_id is mandatory"];
        }
      
   
    
    
        if (!$email) {
        DB::rollback(); 
        return ["status" => false, "message" => "email is mandatory"];
     }
  
    
      
          if (!$phone) {
            DB::rollback(); 
            return ["status" => false, "message" => "phone is mandatory"];
    }
  
 
         if (!$office_location) {
           DB::rollback(); 
           return ["status" => false, "message" => "office_location is mandatory"];
         }
   
  
  
//   $insertQuery = "insert into  Counselors (name,staff_id,email,phone,office_location)values('$name','$staff_id',$email','$phone','$office_location')";
$insertQuery = "INSERT INTO Counselors (name, staff_id, email, phone, office_location) VALUES ('$name', '$staff_id', '$email', '$phone', '$office_location')";
 $a= DB::select($insertQuery);
 Log::warning($a);
  DB::commit();
  return ["status" => true, "data" => [], "message" => "$name,$staff_id,$email,$phone,$office_location added successfully"];
    } catch (Exception $e) {
        Log::warning($e);
        DB::rollBack();
        return ["status" => false, "message" => $e->getMessage()];
    }
      
    }
    public function updatecounselors($id, $name, $email, $phone,$office_location)
    {
    DB::beginTransaction();
    try {
        if (!$id) {
            DB::rollBack();
            return ["status" => false, "message" => "id is mandatory"];
        }

        $Counselors = DB::table('Counselors')
            ->where('id', $id)
            ->first();

        if (!$Counselors) {
            DB::rollBack();
            return ["status" => false, "message" => "Data not available"];
        }

        $updateData = [];

        if ($name) {
            $updateData['name'] = $name;
        }

        if ($email) {
            $updateData['email'] = $email;
        }
        if ($phone) {
          $updateData['phone'] = $phone;
      }
      if ($office_location) {
        $updateData['office_location'] = $office_location;
    }

        DB::table('Counselors')
            ->where('id', $id)
            ->update($updateData);

        DB::commit();
        return ["status" => true, "message" => "$id updated successfully"];
    } catch (Exception $e) {
        Log::warning($e);
        DB::rollback();
        return ["status" => false, "message" => $e->getMessage()];
    }
}
public function deleteCounselors($id)
{
    DB::beginTransaction();
    try {
        if (!$id) {
            DB::rollBack();
            return ["status" => false, "message" => "id is mandatory"];
        }
        $Counselors = Counselors::find($id)->delete();
        DB::commit();
        return ["status" => true, "data" => [$Counselors], "message" => "deleted successfully"];
    } catch (Exception $th) {
        Log::warning($th);
        DB::rollBack();
        return ["status" => false, "message" => $th->getMessage()];
    }
}
public function showAllcounselors(){
    DB::beginTransaction();
    try {
        
        $Counselors = Counselors::paginate(60);
        DB::commit();
        return ["status" => true, "data" => $Counselors, "message" => " Counselors data list  successfully"];
    } catch (Exception $e) {
        Log::warning($e);
        DB::rollBack();
        return ["status" => false, "message" => $e->getMessage()];
    }
}

public function listbyId($id)
{
    DB::beginTransaction();
    try {
        
        if (!$id) {
            DB::rollBack();
            return ["status" => false, "message" => "ID is mandatory"];
        }
    
        $Counselors = DB::table('counselors')
            ->where('id', $id)
            ->first();
        
        if (!$Counselors) {
            DB::rollBack();
            return ["status" => false, "message" => "Id is invalid"];
        }
        DB::commit();
        return ["status" => true, "data" => $Counselors, "message" => "counselors data fetched successfully"];
    } catch (Exception $e) {
        Log::warning($e);
    }
}
}