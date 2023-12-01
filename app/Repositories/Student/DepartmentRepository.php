<?php

namespace App\Repositories\Student;

use App\Models\College;
use App\Models\Department;
use App\Repositories\BaseRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DepartmentRepository implements BaseRepositoryInterface
{
    public function all()
    {
    }
    public function createDepartment(array $data, $filePath)
    {
        try {
            DB::beginTransaction();

              $existingDepartment = Department::where('name', $data['name'])->first();

            if ($existingDepartment) {
                 return response()->json(['message' => 'Department with this name already exists.'], 422);
            }

               $collegeExists = College::where('college_id', $data['college_id'])->exists();

            if (!$collegeExists) {
                return response()->json(['message' => 'College with this ID does not exist.'], 422);
            }

            $department = Department::create([
                'college_id' => $data['college_id'],
                'name' => $data['name'],
                'image' => $filePath,
                // 'department_id' => $data['department_id'],
                'description' => $data['description'],
                 ]);

            DB::commit();

            return response()->json($department, 201);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());

              return response()->json(['message' => 'An error occurred while creating the department.'], 500);
        }
    }
    public function updateDepartment($data,$filePath){
        try{
            DB::beginTransaction();
            if(!$data['id']){
                return ['status'=>false,'message'=>'id is mandatory'];
            }
            $updatableFields=[
                'name',
                'description'
            ];
            $departmentData = [];
 
            foreach ($updatableFields as $field) {
                if (isset($data[$field])) {
                $departmentData[$field] = $data[$field];
                }
            }
       $department=Department::where('id',$data['id'])->where('is_deleted','no')->first();
       if (!$department) {
        DB::rollback();
        return ["status" => false, "message" => "id not found"];
    }   
    if (!empty($filePath)) {
                $department->image = $filePath;
            }
            $department->update($departmentData);
            $department->fresh();
            DB::commit();
            return ["status" => true,'data'=>$department, "message" => "department updated successfully"];
     
        }
        catch(Exception $e){
           return ['status'=>false,'message'=>$e->getMessage()]; 
        }
    }

    public function deleteDepartment($id)
    {
        try {
            DB::beginTransaction();
    
            if (!$id) {
                return ['status' => false, 'message' => 'ID is mandatory'];
            }
    
            $department = Department::where('id', $id)->where('is_deleted', 'no')->first();
    
            if (!$department) {
                return ['status' => false, 'message' => 'Department does not exist or is already deleted'];
            }
    
            $updateDepartment = Department::where('id', $id)->update(['is_deleted' => 'yes']);
    
            DB::commit();
    
            return ['status' => true, 'data' => $updateDepartment, 'message' => "$id removed successfully"];
        } catch (\Exception $e) {
            DB::rollBack();
    
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }
    

    public function getAllDepartment($search)
    { 
        try {
            $query = Department::query();

            if ($search) {
                $query->where('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('description', 'LIKE', '%' . $search . '%');
            }

            $departments = $query->where('is_deleted', 'no')->get();

            return ['status' => true, 'data' => $departments];
        } catch (\Exception $e) {
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }
    public function  departmentStatus($id, $status)
     {             


        DB::beginTransaction();
        try {
            // Find department by ID 
            $department = Department::find($id);
    
            if (!$department) {
                DB::rollBack();
                return ['status' => false, 'message' => 'Department not found'];
            }
    
            // Update the status
            $updateQuery = Department::where('id', $id)->update(['is_active' => $status]);
            $updatedDepartment = Department::find($id);

            DB::commit();
    
            return ['status' => true, 'data' => $updatedDepartment, 'message' => 'Status updated successfully'];
        } catch (\Exception $th) {
            Log::error($th);
            DB::rollBack();
            return ['status' => false, 'message' => $th->getMessage()];
        }

}

     



}