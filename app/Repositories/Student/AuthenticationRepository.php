<?php

namespace App\Repositories\Student;

use App\Models\User;
use App\Repositories\BaseRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class AuthenticationRepository implements BaseRepositoryInterface
{
    public function all()
    {
    }

    public function createUser($request,$imagePath){
        $user = User::create([
            'name' => $request['name'],
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
            'files' => $imagePath
        ]);
    }
}
