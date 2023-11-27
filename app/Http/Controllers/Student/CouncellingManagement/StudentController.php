<?php

namespace App\Http\Controllers\Student\CouncellingManagement;

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

    public function createStudent(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'first_name' => 'required|string',
                'user_id' => 'required',
                'last_name' => 'required|string|unique:users,email',

            ]);

            $imagePath = [];
            $imageDirectory = "assets/college_management/students/files";
            if ($request->hasFile('files')) {
                $productFiles = $request->file('files');
                foreach ($productFiles as $key => $value) {
                    $imagePath[] = $this->img->uploadImage($value, $imageDirectory);
                }
            }

            $validator->validate();

            return $this->repo->createStudent($request->all(), $imagePath);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }


    public function updateStudent(Request $req)
    {
        Log::warning($req);
        try {
            $validator = Validator::make($req->all(), [
                'student_id' => 'required',
            ]);
            $imagePath = [];
            $imageDirectory = "assets/college_management/students/files";
            if ($req->hasFile('files')) {
                $productFiles = $req->file('files');
                foreach ($productFiles as $key => $value) {
                    $imagePath[] = $this->img->uploadImage($value, $imageDirectory);
                }
            }
            $validator->validate();

            return $this->repo->updateStudent($req->all(), $imagePath);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function studentShowData(Request $req)
    {
        $search = $req->input('search', '');
        return $this->repo->studentShowData($search);
    }

    public function studentDeleteData(Request $req)
    {
        $id = $req->input('id');
       return $this->repo->studentDeleteData($id);
    }


    public function studentGetData(Request $req)
    {
        $id = $req->input('id');
        return $this->repo->studentGetData($id);
    }
}
