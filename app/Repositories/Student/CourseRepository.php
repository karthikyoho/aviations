<?php

namespace App\Repositories\Student;

use App\Models\College;
use App\Models\Course;
use App\Models\Department;
use App\Repositories\BaseRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CourseRepository implements BaseRepositoryInterface
{
    public function all()
    {
        //
    }
                    //create AcademicTermsCondition
                    public function create($college_id,$department_id,$name,$description,$course_duraton,$filePath)
                    {
                        DB::beginTransaction();
                    
                        try {
                            $id = "COURSEID";
                            $course_id = self::generateUniqueCourseId($id);
                
                            if (!$college_id) {
                                DB::rollBack();
                                return ["status" => false, "message" => "college_id is mandatory"];
                            }
                            if (!$department_id) {
                                DB::rollBack();
                                return ["status" => false, "message" => "department_id is mandatory"];
                            }
                            if (!$name) {
                                DB::rollBack();
                                return ["status" => false, "message" => "name is mandatory"];
                            }
                            if (!$description) {
                                DB::rollBack();
                                return ["status" => false, "message" => "description is mandatory"];
                            }
                            if (!$course_duraton) {
                                DB::rollBack();
                                return ["status" => false, "message" => "course_duraton is mandatory"];
                            }
                            if (!$filePath) {
                                DB::rollBack();
                                return ["status" => false, "message" => "filePath is mandatory"];
                            }
                    
                            $college = College::where('college_id', $college_id)
                                ->where('is_deleted', 'no')
                                ->first();

                            if (!$college) {
                                DB::rollBack();
                                return ["status" => false, "message" => "College ID is not available in colleges table"];
                            }
                            $department = Department::where('department_id', $department_id)
                            ->where('is_deleted', 'no')
                            ->first();
                            
                        if (!$department) {
                            DB::rollBack();
                            return ["status" => false, "message" => "Department ID is not available in departments table"];
                        }
                
                    
                            $data =Course::create([
                                "college_id"=>$college_id,
                                "department_id" => $department_id,  
                                "course_id"=>$course_id,
                                "name" => $name,
                                "description" => $description,
                                "course_duraton" => $course_duraton,
                                "image" => $filePath,
                            ]);
                    
                            DB::commit();
                            return ["status" => true, "data" => $data, "message" => "Data is created successfully"];
                        } catch (Exception $e) {
                            Log::warning($e);
                            DB::rollBack();
                            return ["status" => false, "message" => $e->getMessage()];
                        }
                    }
                    
    private static function generateUniqueCourseId($prefix)
    {
        // Find the maximum faq_module_id with the given prefix
        $maxId = Course::where('course_id', 'like', $prefix . '%')->max('course_id');

        // Extract the numeric part, increment, and pad with zeros
        $numericPart = $maxId ? (int) substr($maxId, strlen($prefix)) + 1 : 1;
        $newId = $prefix . str_pad($numericPart, 4, '0', STR_PAD_LEFT);

        return $newId;
    }
}