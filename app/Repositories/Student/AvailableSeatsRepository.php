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
    
public function update($id,$year,$total_seats,$allocate_seats)
{
DB::beginTransaction();
try {
    if (!$id) {
        DB::rollBack();
        return ["status" => false, "message" => "id is mandatory"];
    }

    if (!$year) {
        DB::rollBack();
        return ["status" => false, "message" => "year is mandatory"];
    }


    if (!$total_seats) {
        DB::rollBack();
        return ["status" => false, "message" => "total_seats is mandatory"];
    }
    if (!$allocate_seats) {
        DB::rollBack();
        return ["status" => false, "message" => "allocate_seats is mandatory"];
    }
   
    $availableSeats = DB::table('available_seats')
        ->where('id', $id,)
        ->where('year',$year)
        ->first();

    $available_seat=$total_seats-$allocate_seats;
    


    if (!$availableSeats) {
        DB::rollBack();
        return ["status" => false, "message" => "Data not available"];
    }

    $updateData = [];

   
    if ($total_seats) {
        $updateData['total_seats'] = $total_seats;
    }
    if ($allocate_seats) {
        $updateData['allocate_seats'] = $allocate_seats;
    }
    if ($available_seat) {
        $updateData['available_seats'] = $available_seat;
    }
   

    DB::table('available_seats')
        ->where('id', $id)
        ->where('year',$year)
        ->update($updateData);

    DB::commit();
    return ["status" => true, "message" => "$id updated successfully"];
} catch (Exception $e) {
    Log::warning($e);
    DB::rollback();
    return ["status" => false, "message" => $e->getMessage()];
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
        $availableSeats = AvailableSeats::find($id)->delete();
        DB::commit();
        return ["status" => true, "data" => [$availableSeats], "message" => "deleted successfully"];
    } catch (Exception $th) {
        Log::warning($th);
        DB::rollBack();
        return ["status" => false, "message" => $th->getMessage()];
    }


}


}