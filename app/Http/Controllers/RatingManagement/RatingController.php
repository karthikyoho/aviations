<?php

namespace App\Http\Controllers\RatingManagement;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use App\Repositories\RatingRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RatingController extends Controller
{
    protected $repo;
    public function __construct(RatingRepository $repo)
    {
      $this->repo = $repo;
    }


    public function create(Request $req){
        Log::warning($req);
        $college_id=$req->input('college_id');
        $rating=$req->input('rating');
        $comment=$req->input('comment');
        return $this->repo->createRatings($college_id,$rating,$comment);

    }

    public function update(Request $req){
        Log::warning($req);
        $id=$req->input('id');
        $rating=$req->input('rating');
        $comment=$req->input('comment');

        return $this->repo->updateRatings($id,$rating,$comment);
    }


    // }
            //delete 
    public function delete(Request $req){
        Log::warning($req);
        $id=$req->input('id');
        return $this->repo->deleteRatings($id);
    }

    //  }
    //     //show All 
      public function showAll(Request $req){
        $search = $req->input('search', '');
         return $this->repo->showAllRatings($search);
     }

    //   //show  data  by Id
    
     public function listbyid(Request $req){
         $id=$req->input('id');
         return $this->repo->listbyId($id);
     }
    

}
