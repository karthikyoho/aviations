<?php

namespace App\Repositories\Student;

use App\Models\User;
use App\Repositories\BaseRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProfileRepository implements BaseRepositoryInterface
{
    public function all()
    {
        //
    }

    public function getStudentByUserId($user_id){
   
            DB::beginTransaction();
            try {
                if (!$user_id) {
                    DB::rollBack();
                    return ["status" => false, "message" => "id is mandatory"];
                }
                $studentByUserId =User::
                      where('id', $user_id)
                    ->where('is_deleted', 'no')
                    ->where('is_active', 'yes')
                    ->with('students')
                    ->first();
    
                if (!$studentByUserId) {
                    DB::rollBack();
                    return ["status" => false, "message" => "Id is invalid"];
                }
    
            return ["status" => true, "data" => $studentByUserId, "message" => " student data listed by user_id successfully"];
        } catch (Exception $e) {
            Log::warning($e);
            DB::rollBack();
            return ["status" => false, "message" => $e->getMessage()];
        }
    }
   
}
