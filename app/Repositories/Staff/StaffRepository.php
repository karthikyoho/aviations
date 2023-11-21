<?php

namespace App\Repositories\Staff;

use App\Models\College;
use App\Models\Staff;
use App\Repositories\BaseRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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


    public function updateStaff($staff_id,$staff_name){
        if (!$staff_id) {
            return ["status" => false, "message" => "Staff name Id is mandatory"];
        }

        $check = Staff::where('staff_id',$staff_id)->first();
        if(!$check){
            return ["status" => false, "message" => "Staff doesnot exist"];
        }

        $update = Staff::where('staff_id',$staff_id)->update(['staff_name',$staff_name]);
       
        return["status" => true , "message" => "Staff updated Successfully"];
    

    }


    public function deleteStaff($id)
    {
        DB::beginTransaction();
        try {
            if (!$id) {
                DB::rollBack();
                return ["status" => false, "message" => "id is mandatory"];
            }

            $staff = Staff::find($id)->update(['is_deleted' => 'yes']);
            DB::commit();
            return ["status" => true, "data" => [$staff], "message" => "Staff deleted successfully"];
        } catch (Exception $th) {
            Log::warning($th);
            DB::rollBack();
            return ["status" => false, "message" => $th->getMessage()];
        }
    }


    public function show($search)
    {
        DB::beginTransaction();
        try {

            $college = Staff::where('is_deleted', 'no')->where('is_active', 'yes')->when($search, function ($query) use ($search) {
                $query->where('staff_name', 'like', '%' . $search . '%');
            })->paginate(60);
            return ["status" => true, "data" => $college, "message" => "Staff data displayed successfully"];
        } catch (Exception $e) {
            Log::warning($e);
            DB::rollBack();
            return ["status" => false, "message" => $e->getMessage()];
        }
    }

    public function status($id, $status)
    {
        DB::beginTransaction();
        try {
            if (!$id) {
                DB::rollBack();
                return ["status" => false, "message" => "Id is mandatory"];
            }
            if (!$status) {
                DB::rollBack();
                return ["status" => false, "message" => "Status is mandatory"];
            }
    
            $staff =Staff::find($id);
    
            if (!$staff) {
                DB::rollBack();
                return ["status" => false, "message" => "Data not found"];
            }
    
            $staff->update(['is_active' => $status]);
            $staff->refresh();  
    
            DB::commit();
    
            return ["status" => true, "data" => [], "message" => "Staff status updated successfully"];
        } catch (Exception $th) {
            Log::warning($th);
            DB::rollBack();
            return ["status" => false, "message" => $th->getMessage()];
        }
    }
    
    public function getStaffById($id)
    {
        DB::beginTransaction();
        try {
            if (!$id) {
                DB::rollBack();
                return ["status" => false, "message" => "id is mandatory"];
            }
            $staff = DB::table('colleges')
                ->where('id', $id)
                ->where('is_deleted', 'no')
                ->first();

            if (!$staff) {
                DB::rollBack();
                return ["status" => false, "message" => "Id is invalid"];
            }

            DB::commit();
            return ["status" => true, "data" => $staff, "message" => "staff data fetched successfully"];
        } catch (Exception $e) {
            Log::warning($e);
            DB::rollBack();
            return ["status" => false, "message" => $e->getMessage()];
        }
    }
    private static function generateUniqueAcademicId($prefix)
    {     
        $maxId = Staff::where('staff_id', 'like', $prefix . '%')->max('staff_id');
        $numericPart = $maxId ? (int) substr($maxId, strlen($prefix)) + 1 : 1;
        $newId = $prefix . str_pad($numericPart, 4, '0', STR_PAD_LEFT);
        return $newId;
    }
}
