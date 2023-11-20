<?php

namespace App\Http\Controllers\Student\Authentication;

use App\Http\Controllers\Controller;
use App\Repositories\ImageRepository;
use App\Repositories\Student\AuthenticationRepository;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthenticationController extends Controller
{
    protected $repo;
    protected $img;
    public function __construct(AuthenticationRepository $repo ,ImageRepository $img)
    {
        $this->repo = $repo;
        $this->img = $img;
    }


    public function register(Request $request){
        // DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(),[
                'name' => 'required|string',
                'email' => 'required|string|unique:users,email',
                'phone' =>'required|unique:users,phone',
                'password' => 'required',              
            ]);           
            $validator->validate();          

            $imagePath=[];
            $imageDirectory = "assets/student/images";//image storing folder
            if($request->hasFile('files')){ //col name
                $productFiles = $request->file('files');//col name
                foreach($productFiles as $key => $value){
                    $imagePath[] = $this->img->uploadImage($value,$imageDirectory);
                }
            }
            return $this->repo->createUser($request->all(),$imagePath);           
        }
        catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
         catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }


}
