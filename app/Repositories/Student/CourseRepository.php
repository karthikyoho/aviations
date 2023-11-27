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
                    public function create($college_id,$department_id,$name,$description,$course_duration,$total_seats,$available_seats,$filePath)
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
                            if (!$course_duration) {
                                DB::rollBack();
                                return ["status" => false, "message" => "course_duration is mandatory"];
                            }
                            if (!$total_seats) {
                                DB::rollBack();
                                return ["status" => false, "message" => "total_seats is mandatory"];
                            }
                            if (!$available_seats) {
                                DB::rollBack();
                                return ["status" => false, "message" => "available_seats is mandatory"];
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
                                "course_duration" => $course_duration,
                                "total_seats"=>$total_seats,
                                "available_seats"=>$available_seats,
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
                    

                    public function update($id, $name, $description, $course_duration,$available_seats,$total_seats, $filePath)
                    {
                        try {
                            if (!$id) {
                                DB::rollBack();
                                return ["status" => false, "message" => "id is mandatory"];
                            }
                    
                            $course = Course::find($id);
                    
                            if (!$course) {
                                DB::rollBack();
                                return ["status" => false, "message" => "Course Data is not available"];                            }
                    
                            if ($name) {
                                $course->name = $name;
                            }
                    
                            if ($description) {
                                $course->description = $description;
                            }
                    
                            if ($course_duration) {
                                $course->course_duration = $course_duration;
                            }
                            if ($available_seats) {
                                $course->available_seats = $available_seats;
                            }

                            if ($total_seats) {
                                $course->total_seats = $total_seats;
                            }
                    
                            if ($filePath) {
                                $course->image = $filePath;
                            }
                    
                            $course->save();
                    
                            return ["status" => true, "message" => "$id updated successfully"];
                        } catch (\Exception $e) {
                            Log::warning($e);
                    
                            return ["status" => false, "message" => $e->getMessage()];
                        }
                    }
                   
                    //delete Course Data by id
                    public function delete($id)
                    {
                        DB::beginTransaction();
                        try {
                            if (!$id) {
                                DB::rollBack();
                                return ["status" => false, "message" => "id is mandatory"];
                            }
                
                            $course= Course::find($id)->update(['is_deleted' => 'yes']);
                            DB::commit();
                            return ["status" => true, "data" => [$course], "message" => "deleted successfully"];
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
                
                            $course = Course::where('is_deleted', 'no')->where('is_active', 'yes')->when($search, function ($query) use ($search) {
                                $query->where('name', 'like', '%' . $search . '%');
                            })->paginate(60);
                            return ["status" => true, "data" => $course, "message" => "Course data displayed successfully"];
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
    
            $course =Course::find($id);
    
            if (!$course) {
                DB::rollBack();
                return ["status" => false, "message" => "Data not found"];
            }
    
            $course->update(['is_active' => $status]);
            $course->refresh();  
    
            DB::commit();
    
            return ["status" => true, "data" => [], "message" => "course status updated successfully"];
        } catch (Exception $th) {
            Log::warning($th);
            DB::rollBack();
            return ["status" => false, "message" => $th->getMessage()];
        }
    }

    
    public function getCourseById($id)
    {
        DB::beginTransaction();
        try {
            if (!$id) {
                DB::rollBack();
                return ["status" => false, "message" => "id is mandatory"];
            }
            $course = DB::table('courses')
                ->where('id', $id)
                ->where('is_deleted', 'no')
                ->where('is_active', 'yes')
                ->first();

            if (!$course) {
                DB::rollBack();
                return ["status" => false, "message" => "Id is invalid"];
            }

            DB::commit();
            return ["status" => true, "data" => $course, "message" => "courses data fetched successfully"];
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