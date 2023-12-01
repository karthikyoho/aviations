<?php

namespace App\Repositories;

use App\Models\Rating;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RatingRepository implements BaseRepositoryInterface
{
public function all()

{
}

public function createRatings($college_id,$rating,$comment)
{
    DB::beginTransaction();
    try {
        if (!$college_id) {
            DB::rollback(); 
            return ["status" => false, "message" => "college_id is mandatory"];
        }

        if (!$rating) {
            DB::rollback(); 
            return ["status" => false, "message" => "rating is mandatory"];
        }
      
        if (!$comment) {
          DB::rollback(); 
          return ["status" => false, "message" => "comment is mandatory"];
       }
   
       $insertQuery = "INSERT INTO Ratings (college_id,rating,comment) VALUES ('$college_id', '$rating', '$comment')";
        $a= DB::select($insertQuery);
        Log::warning($a);
        DB::commit();
         return ["status" => true, "data" => [], "message" => "$college_id,$rating,$comment"];
      } catch (Exception $e) {
       Log::warning($e);
       DB::rollBack();
       return ["status" => false, "message" => $e->getMessage()];
   }
}
public function updateRatings($id, $rating, $comment)
{
DB::beginTransaction();
try {
    if (!$id) {
        DB::rollBack();
        return ["status" => false, "message" => "id is mandatory"];
    }
   
    $Ratings = DB::table('Ratings')
        ->where('id', $id)
        ->first();


    if (!$Ratings) {
        DB::rollBack();
        return ["status" => false, "message" => "Data not available"];
    }

    $updateData = [];

    if ($rating) {
        $updateData['rating'] = $rating;
    }

    if ($comment) {
        $updateData['comment'] = $comment;
    }
   

    DB::table('Ratings')
        ->where('id', $id)
        ->update($updateData);

    DB::commit();
    return ["status" => true, "message" => "$id updated successfully"];
} catch (Exception $e) {
    Log::warning($e);
    DB::rollback();
    return ["status" => false, "message" => $e->getMessage()];
}
}

public function deleteRatings($id)
{
    DB::beginTransaction();
    try {
        if (!$id) {
            DB::rollBack();
            return ["status" => false, "message" => "id is mandatory"];
        }
        $Ratings = Rating::find($id)->delete();
        DB::commit();
        return ["status" => true, "data" => [$Ratings], "message" => "deleted successfully"];
    } catch (Exception $th) {
        Log::warning($th);
        DB::rollBack();
        return ["status" => false, "message" => $th->getMessage()];
    }


}

public function showAllRatings(){
    DB::beginTransaction();
    try {
        
        $Ratings = Rating::paginate(60);
        DB::commit();
        return ["status" => true, "data" => $Ratings, "message" => " Ratings data list  successfully"];
    } catch (Exception $e) {
        Log::warning($e);
        DB::rollBack();
        return ["status" => false, "message" => $e->getMessage()];
    }
}

public function listbyId($id)
{
    DB::beginTransaction();
    try {
        
        if (!$id) {
            DB::rollBack();
            return ["status" => false, "message" => "ID is mandatory"];
        }
    
        $Ratings = DB::table('Ratings')
            ->where('id', $id)
            ->first();
        
        if (!$Ratings) {
            DB::rollBack();
            return ["status" => false, "message" => "Id is invalid"];
        }
        DB::commit();
        return ["status" => true, "data" => $Ratings, "message" => "Ratings data fetched successfully"];
    } catch (Exception $e) {
        Log::warning($e);
    }
}
    
}
