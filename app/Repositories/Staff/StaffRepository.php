<?php

namespace App\Repositories\Staff;

use App\Models\College;
use App\Models\Staff;
use App\Repositories\BaseRepositoryInterface;
use Exception;

class StaffRepository implements BaseRepositoryInterface
{
    public function all()
    {
    }

    public function staffCreate($college_id, $staff_name)
    {
        try {

            if (!$college_id) {
                return ["status" => false, "message" => "College Id is mandatory"];
            }

            if (!$staff_name) {
                return ["status" => false, "message" => "Staff name Id is mandatory"];
            }
          


            $select_name = College::where('college_id', $college_id)->pluck('college_name')->implode(',');
            
            if (!$select_name) {
                return ["status" => false, "message" => "College is not found"];
            }

            $select_name = trim($select_name);
            $upper = mb_strtoupper($select_name);

            $academicPrefix =  $upper . "STAFFID";
            $newId = self::generateUniqueAcademicId($academicPrefix,$college_id);

            $staff = Staff::create([
                'college_id' => $college_id,
                'staff_name' => $staff_name,
                'staff_id' => $newId
            ]);

            return["status" => true , "message" => "Staff Registered Successfully"];
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 401);
        }
    }


    private static function generateUniqueAcademicId($prefix,$college_id)
    {
        $select = Staff::where('college_id',$college_id)->first();

        if($select){
            
        }



        $maxId = Staff::where('staff_id', 'like', $prefix . '%')->max('staff_id');
        $numericPart = $maxId ? (int) substr($maxId, strlen($prefix)) + 1 : 1;
        $newId = $prefix . str_pad($numericPart, 4, '0', STR_PAD_LEFT);

        return $newId;
    }
}
