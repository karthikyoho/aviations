<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Exception;
use App\Models\Counselors;
use App\Repositories\BaseRepositoryInterface;
use Illuminate\Support\Facades\Log;

class CounselorsRepository implements BaseRepositoryInterface
{
    public function all()
    {
    }

  
    public function createCounselors($name,$email,$phone,$office_location)
    {

        DB::beginTransaction();
        try {
            if (!$name) {
                DB::rollback(); 
                return ["status" => false, "message" => "name is mandatory"];
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
       
      
      

      $insertQuery = "insert into  Counselors (name,email,phone,office_location)values('$name','$email','$phone','$office_location')";
      DB::select($insertQuery);
      DB::commit();
      return ["status" => true, "data" => [], "message" => "$name,$email,$phone,$office_location added successfully"];
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
  }