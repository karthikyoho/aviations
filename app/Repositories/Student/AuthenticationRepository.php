<?php

namespace App\Repositories\Student;

use App\Models\User;
use App\Repositories\BaseRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AuthenticationRepository implements BaseRepositoryInterface
{
    public function all()
    {
    }

    public function createUser($request)
    {
        try {
            $user = User::create([
                'name' => $request['name'],
                'DOB' => $request['DOB'],
                'phone' => $request['phone'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                'is_active' => 'yes',
                'address_line1' => $request['address_line1'],
                'address_line2' => $request['address_line2'],
                'SSLC mark' => $request['SSLCmark'],
                'HSC mark' => $request['HSCmark'],
                '1st_priority' => $request['1st_priority'],
                '2nd_priority' => $request['2nd_priority'],
                '3rd_priority' => $request['3rd_priority'],
                'preferred_location1' => $request['preferred_location1'],
                'preferred_location2' => $request['preferred_location2'],
                // 'files' => $imagePath
            ]);

            return ["status" => true, "data" => "registered successfully"];
        } catch (Exception $e) {

            return response()->json(['message' => $e->getMessage()], 401);
        }
    }





    public function login($credentials){
        try {
            if(Auth::attempt($credentials)){
                $user = Auth::user();
                Log::warning($user);                           
        
                $token = auth()->user()->createToken('AuthToken')->accessToken;
                $response = [
                    "user_id"=>$user->id,
                    "name"=>$user->name,
                    "email"=>$user->email,
                    "phone"=>$user->phone,
                    "token"=>$token
                ];
                return ["status"=>true,"message"=>"Login successfull","data"=>$response];                
               
            }
            else {
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect.'],
                ]);
            }
        } catch (Exception $e) {
            Log::warning($e->getMessage());
            return ["status"=>false,"message"=>$e->getMessage()];
        }

    }
}
