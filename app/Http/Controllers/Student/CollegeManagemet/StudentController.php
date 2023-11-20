<?php

namespace App\Http\Controllers\Student\CollegeManagemet;

use App\Http\Controllers\Controller;
use App\Repositories\ImageRepository;
use App\Repositories\Student\StudentRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class StudentController extends Controller
{
    protected $repo;
    protected $img;
    public function __construct(StudentRepository $repo, ImageRepository $img)
    {
        $this->repo = $repo;
        $this->img = $img;
    }
    
    public function createUser(Request $request)
    {
        Log::warning($request);
        DB::beginTransaction();
    
        try {
            $first_name = $request->input('first_name');
            $last_name = $request->input('last_name');
            $father_name = $request->input('father_name');
            $mother_name = $request->input('mother_name');
            $father_occupation = $request->input('father_occupation');
            $height = $request->input('Height');
            $weight = $request->input('weight');
            $gender = $request->input('gender');
            $marital_status = $request->input('marital_status');
            $age = $request->input('age');
            $dob = $request->input('DOB');
            $sslc_mark = $request->input('SSLC_mark');
            $hsc_mark = $request->input('HSC_mark');
            $city = $request->input('city');
            $state = $request->input('state');
            $pincode = $request->input('pincode');
            $email = $request->input('email');
            $phone = $request->input('phone');
            $passport = $request->input('passport');
            $password = $request->input('password');
    
            $studentGalleryPath = "assets/college_management/student/files";
            $gallery = [];
    
            if ($request->hasFile('files')) {
                $studentfiles = $request->file('files');
    
                foreach ($studentfiles as $studentfile) {
                    $gallery[] = $this->img->uploadImage($studentfile, $studentGalleryPath);
                }
            }
    
            // Assuming $this->repo is an instance of your repository class
            return $this->repo->create([
                'first_name' => $first_name,
                'last_name' => $last_name,
                'father_name' => $father_name,
                'mother_name' => $mother_name,
                'father_occupation' => $father_occupation,
                'height' => $height,
                'weight' => $weight,
                'gender' => $gender,
                'marital_status' => $marital_status,
                'age' => $age,
                'dob' => $dob,
                'sslc_mark' => $sslc_mark,
                'hsc_mark' => $hsc_mark,
                'city' => $city,
                'state' => $state,
                'pincode' => $pincode,
                'email' => $email,
                'phone' => $phone,
                'passport' => $passport,
                'password' => $password,
                'files' => $gallery,
            ]);
        } catch (ValidationException $e) {
            DB::rollBack();
            Log::warning($e);
            return ['errors' => $e->errors()];
        }
    }
}