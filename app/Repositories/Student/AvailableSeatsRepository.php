<?php

namespace App\Repositories\Student;

use App\Models\AvailableSeats;
use App\Repositories\BaseRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AvailableSeatsRepository implements BaseRepositoryInterface
{
    public function all()
    {
    }

    public function create($course_id,$college_id,$total_seats,$allocate_seats,$year){
        DB::beginTransaction();
        try{


            $available_seat=$total_seats-$allocate_seats;

            $availableSeats=AvailableSeats::create([
               "course_id"=> $course_id,
                "college_id"=>$college_id,
                "total_seats"=>$total_seats,
                'available_seats'=>$available_seat,
                "allocate_seats"=>$allocate_seats,
                // $year=>"year",

            ]);
            $availableSeats->save();
            DB::commit();
            return ["status"=>true, "data"=>[$availableSeats], "message"=>"Available seats data created successfully"];
        }catch(Exception $th){
            Log::warning($th);
            DB::rollBack();
            return ["status"=>false, "message"=>$th->getMessage()];
        }


    }

}