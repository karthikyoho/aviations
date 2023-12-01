<?php

namespace App\Repositories\Student;

use App\Models\CouncellingAppointment;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Models\CounselingAppointments;
use App\Models\Counselors;
use App\Models\Course;
use App\Models\Staff;
use App\Models\Student;
use App\Repositories\BaseRepositoryInterface;
use Illuminate\Support\Facades\Log;

class CounselingAppointmentsRepository implements BaseRepositoryInterface
{
  public function all()
    {
    }
    public function createAppointment($data)
    {
        try {
            // Check if counselor data exists
            $counselorData = Counselors::where('id', $data['counselor_id'])->first();
            if (!$counselorData) {
                return ['status' => false, 'message' => 'Counselor data not found'];
            }
    
            // Check if student data exists
            $studentData = Student::where('student_id', $data['student_id'])->first();
            if (!$studentData) {
                return ['status' => false, 'message' => 'Student data not found'];
            }
    
            // Check if course data exists
            $course = Course::where('course_id', $data['course_id'])->where('is_deleted', 'no')->first();
            if (!$course) {
                return ['status' => false, 'message' => 'Course data not found'];
            }
    
            // Check if the same appointment exists with the given start time, end time, and counseling date
            $existingAppointment = CouncellingAppointment::where([
                'counselor_id' => $data['counselor_id'],
                'counseling_date' => $data['counseling_date'],
            ])->where(function ($query) use ($data) {
                $query->whereBetween('start_time', [$data['start_time'], $data['end_time']])
                    ->orWhereBetween('end_time', [$data['start_time'], $data['end_time']])
                    ->orWhere(function ($query) use ($data) {
                        $query->where('start_time', '<=', $data['start_time'])
                            ->where('end_time', '>=', $data['end_time']);
                    });
            })->first();
    
            if ($existingAppointment) {
                return ['status' => false, 'message' => 'Appointment time slot is not available'];
            }
    
            // Create the appointment
            $appointment = CouncellingAppointment::create([
                'counselor_id' => $data['counselor_id'],
                'student_id' => $data['student_id'],
                'start_time' => $data['start_time'],
                'counselling_mode'=>$data['counselling_mode'],
                'end_time' => $data['end_time'],
                'notes' => $data['notes'],

                'counseling_date' => $data['counseling_date'],
            ]);
    
            return ['status' => true, 'data' => $appointment, 'message' => 'Appointment created successfully'];
        } catch (Exception $e) {
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }
    
    
    public function updateAppointment(array $data)
    {
        try {
            DB::beginTransaction();
    
            // Find the appointment by id
            $appointment = CouncellingAppointment::find($data['id']);
    
            if (!$appointment) {
                return ['status' => false, 'message' => 'Appointment not found'];
            }
    
            // Update each field if present in the data
            $updatableFields = ['start_time', 'end_time', 'counseling_date', 'notes','counseling_mode'];
    
            foreach ($updatableFields as $field) {
                if (isset($data[$field])) {
                    $appointment->$field = $data[$field];
                }
            }
    
            $appointment->save();
             
            DB::commit();
    
            return ['status' => true, 'data' => $appointment, 'message' => 'Appointment updated successfully'];
        } catch (Exception $e) {
            DB::rollBack();
    
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            if (!$id) {
                DB::rollBack();
                return ["status" => false, "message" => "id is mandatory"];
            }

            $coucellingAppoinment= CouncellingAppointment::find($id)->update(['is_deleted' => 'yes']);
            DB::commit();
            return ["status" => true, "data" => [$coucellingAppoinment], "message" => "deleted successfully"];
        } catch (Exception $th) {
            Log::warning($th);
            DB::rollBack();
            return ["status" => false, "message" => $th->getMessage()];
        }
    }
        
    public function show()
    {
        DB::beginTransaction();
        try {

            $coucellingAppoinment = CouncellingAppointment::where('is_deleted', 'no')->where('is_active', 'yes')->paginate(60);
            return ["status" => true, "data" => $coucellingAppoinment, "message" => "Course data displayed successfully"];
        } catch (Exception $e) {
            Log::warning($e);
            DB::rollBack();
            return ["status" => false, "message" => $e->getMessage()];
        }
    }

    public function getCouncellingAppointmentById($id)
    {
        DB::beginTransaction();
        try {
            if (!$id) {
                DB::rollBack();
                return ["status" => false, "message" => "id is mandatory"];
            }
            $coucellingAppoinment = DB::table('counseling_appointments')
                ->where('id', $id)
                ->where('is_deleted', 'no')
                ->where('is_active', 'yes')
                ->first();

            if (!$coucellingAppoinment) {
                DB::rollBack();
                return ["status" => false, "message" => "Id is invalid"];
            }

            DB::commit();
            return ["status" => true, "data" => $coucellingAppoinment, "message" => "councellingAppointment data fetched successfully"];
        } catch (Exception $e) {
            Log::warning($e);
            DB::rollBack();
            return ["status" => false, "message" => $e->getMessage()];
        }
    }
}