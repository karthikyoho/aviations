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

    public function createUser($request,$filePath)
    {
        try {

            $emailParts = explode('@', $request['email']);

            $removespace =  $emailParts[0]. $request['phone'] ;
            $password = str_replace(' ', '', $removespace);        
            Log::warning($password);

            $Prefix =   "REG_ID";
            $newId = self::generateUniqueAcademicId($Prefix);

            $user = User::create([
                'name' => $request['name'],
                'phone' => $request['phone'],
                'email' => $request['email'],
                'profile_image' => $filePath,
                'registered_id' => $newId,
                'password' => Hash::make($password),
                'address_line1' => $request['address_line1'],
                'address_line2' => $request['address_line2'],
                '1st_priority' => $request['1st_priority'],
                '2nd_priority' => $request['2nd_priority'],
                '3rd_priority' => $request['3rd_priority'],
                'preferred_location1' => $request['preferred_location1'],
                'preferred_location2' => $request['preferred_location2'],
                'is_active' => 'yes',

            ]);

            return ["status" => true, "data" => "registered successfully",'password' => $password];
        } catch (Exception $e) {

            return response()->json(['message' => $e->getMessage()], 401);
        }
    }





    public function login($credentials)
    {
        try {
            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                Log::warning($user);

                $token = auth()->user()->createToken('AuthToken')->accessToken;
                $response = [
                    "user_id" => $user->id,
                    "name" => $user->name,
                    "email" => $user->email,
                    "phone" => $user->phone,
                    "token" => $token
                ];
                return ["status" => true, "message" => "Login successfull", "data" => $response];
            } else {
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect.'],
                ]);
            }
        } catch (Exception $e) {
            Log::warning($e->getMessage());
            return ["status" => false, "message" => $e->getMessage()];
        }
    }



    private static function generateUniqueAcademicId($prefix)
    {     
        $maxId = User::where('registered_id', 'like', $prefix . '%')->max('registered_id');
        $numericPart = $maxId ? (int) substr($maxId, strlen($prefix)) + 1 : 1;
        $newId = $prefix . str_pad($numericPart, 4, '0', STR_PAD_LEFT);
        return $newId;
    }
}
