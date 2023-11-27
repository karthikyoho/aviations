<?php

namespace App\Repositories\Student;

use App\Models\Student;
use App\Models\User;
use App\Repositories\BaseRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StudentRepository implements BaseRepositoryInterface
{
    public function all()
    {
    }

    public function createStudent($request,$studentGalleryPath)
    {
        DB::beginTransaction();
        try {
        

            $user = User::where('id', $request['user_id'])->first();

            if (!$user) {
                DB::rollBack();
                return ["status" => false, 'message' => 'User not found'];
            }

            $student = Student::create([

                'user_id' => $request['user_id'],
                'first_name' => $request['first_name'],
                'last_name' => $request['last_name'],
                'father_name' => $request['father_name'],
                'mother_name' => $request['mother_name'],
                'father_occupation' => $request['father_occupation'] ?? null,
                'Height' => $request['Height'] ?? null,
                'weight' => $request['weight'] ?? null,
                'gender' => $request['gender'] ?? null,
                'marital_status' => $request['marital_status'] ?? null,
                'age' => $request['age'] ?? null,
                'DOB' => $request['DOB'] ?? null,
                'SSLC_mark' => $request['SSLC_mark'] ?? null,
                'HSC_mark' => $request['HSC_mark'] ?? null,
                'city' => $request['city'] ?? null,
                'state' => $request['state'] ?? null,
                'pincode' => $request['pincode'] ?? null,
                'passport' => $request['passport'] ?? null,
                'files' =>json_encode($studentGalleryPath),
            ]);
            $student->save();
            DB::commit();
            return ["status" => true, "data" => $student, 'message' => 'student created successfully'];
        } catch (\Exception $e) {
            Log::warning($e);
            DB::rollBack();
            return ["status" => false, 'message' => $e->getMessage()];
        }
    }



    public function updateStudent($data,$studentGalleryPath){

       
            try {
                $student = Student::where('student_id', $data['student_id'])->first();
    
                if (!$student) {
                    return ["status" => false, 'message' => 'Student not found'];
                }
    
                $updateData = [];
    
                // Define all fields in the table
                $fields = ['first_name', 'last_name', 'father_name', 'mother_name', 'father_occupation', 'Height', 'weight', 'gender', 'marital_status', 'age', 'DOB', 'SSLC_mark', 'HSC_mark', 'city', 'state', 'pincode', 'passport'];
    
                // Loop through each field and update if it exists in the request
                foreach ($fields as $field) {
                    if (isset($data[$field])) {
                        $updateData[$field] = $data[$field];
                    }
                }
    
                // Check if the 'files' field is present in the request
                if (!empty($studentGalleryPath)) {
                    $updateData['files'] = json_encode($studentGalleryPath);
                }
    
                // Update all fields
                $student->update($updateData);
    
                return ["status" => true, "data" => $student, 'message' => 'Student updated successfully'];
            } catch (\Exception $e) {
                Log::warning($e);
                return ["status" => false, 'message' => $e->getMessage()];
            }
        }
    



        public function studentShowData($search){
            
            
                DB::beginTransaction();
                try {
                    //cayt,subcat,dep
                    $courses = Student::where('is_deleted', 'no')->when($search, function ($query) use ($search) {
                        $query->where('name', 'like', '%' . $search . '%');
                    }) 
                    ->paginate(50);
                    Log::warning($courses);
                    DB::commit();
                    return ["status" => true, "data" => $courses, "message" => "student data list  successfully"];
                } catch (Exception $e) {
                    Log::warning($e);
        
                    DB::rollBack();
                    return ["status" => false, "message" => $e->getMessage()];
                }
            }
        
            public function studentDeleteData($id) //COURSES DELETE FUNCTION
            {
                Log::warning($id);
                DB::beginTransaction();
                try {
        
                    if (!$id) {
                        DB::rollBack();
                        return ["return" => false, "message" => "stduent ID is mandatory"];
                    }
        
                    $check = Student::find($id)->update(['is_deleted'=>'yes']);
                    DB::commit();
                    return ["status" => true, "data" => [$check], "message" => "deleted successfully"];
                } catch (Exception $th) {
                    Log::warning($th);
                    DB::rollBack();
                    return ["status" => false, "message" => $th->getMessage()];
                }
            }


        public function studentGetData($id)
            {
                Log::warning($id);
                DB::beginTransaction();
                try {
        
                    if (!$id) {
                        DB::rollBack();
                        return ["status" => false, "message" => "course  ID is mandatory"];
                    }
                    $departments = "select*from courses where id=$id and is_deleted='no'";
                    $department = DB::select($departments);
                    $departmentcount = count($department);
                    if (!($departmentcount)) {
                        DB::rollBack();
                        return ["status" => false, "message" => "Id is invalid"];
                    }
                    DB::commit();
                    return ["status" => true, "data" => $department, "message" => "categoryId data fetched successfully"];
                } catch (Exception $e) {
                    DB::rollBack();
                    return ["status" => false, "message" => $e->getMessage()];
                }
            }



        }
    




