<?php

namespace App\Repositories\Student;

use App\Models\Student;
use App\Models\User;
use App\Repositories\BaseRepositoryInterface;
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
            return ["status" => true, "data" => $student, 'message' => 'College created successfully'];
        } catch (\Exception $e) {
            Log::warning($e);
            DB::rollBack();
            return ["status" => false, 'message' => $e->getMessage()];
        }
    }



    public function updateStudent($request,$studentGalleryPath){

        try{
            

            $student = Student::where('student_id', $request['student_id'])->first();

            if (!$student) {
                DB::rollBack();
                return ["status" => false, 'message' => 'Student not found'];
            }

           if($request['first_name']){
            $update = Student::where('student_id',$request['student_id'])->update('first_name',$request['first_name']);
           }

           if($request['last_name']){
            $update = Student::where('student_id',$request['student_id'])->update('last_name',$request['last_name']);
           }

           if($request['last_name']){
            $update = Student::where('student_id',$request['student_id'])->update('last_name',$request['last_name']);
           }

           if($request['last_name']){
            $update = Student::where('student_id',$request['student_id'])->update('last_name',$request['last_name']);
           }

           if($request['last_name']){
            $update = Student::where('student_id',$request['student_id'])->update('last_name',$request['last_name']);
           }

           if($request['last_name']){
            $update = Student::where('student_id',$request['student_id'])->update('last_name',$request['last_name']);
           }
           
           if($request['last_name']){
            $update = Student::where('student_id',$request['student_id'])->update('last_name',$request['last_name']);
           }
           if($request['last_name']){
            $update = Student::where('student_id',$request['student_id'])->update('last_name',$request['last_name']);
           }
           if($request['last_name']){
            $update = Student::where('student_id',$request['student_id'])->update('last_name',$request['last_name']);
           }
           if($request['last_name']){
            $update = Student::where('student_id',$request['student_id'])->update('last_name',$request['last_name']);
           }
           if($request['last_name']){
            $update = Student::where('student_id',$request['student_id'])->update('last_name',$request['last_name']);
           }
           if($request['last_name']){
            $update = Student::where('student_id',$request['student_id'])->update('last_name',$request['last_name']);
           }
           
           

           

            DB::commit();
            return ["status" => true, "data" => $student, 'message' => 'Student updated successfully'];
        } catch (\Exception $e) {
            Log::warning($e);
            DB::rollBack();
            return ["status" => false, 'message' => $e->getMessage()];
        }

    }



}
