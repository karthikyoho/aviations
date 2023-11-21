<?php

namespace App\Http\Controllers\Student\CouncellingManagement;

use App\Http\Controllers\Controller;
use App\Models\Counselors;
use App\Repositories\CounselorsRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CounselorsController extends Controller
{
    protected $repo;
    public function __construct(CounselorsRepository $repo)
    {
      $this->repo = $repo;
    }

    public function createCounselors(Request $req){
        Log::warning($req);
        $name=$req->input('name');
        $staff_id=$req->input('staff_id');
        $email=$req->input('email');
        $phone=$req->input('phone');
        $office_location=$req->input('office_location');
        return $this->repo->createCounselors($name,$staff_id,$email,$phone,$office_location);

    }

    public function updateCounselors(Request $req){
        Log::warning($req);
        $id=$req->input('id');
        $name=$req->input('name');
        $email=$req->input('email');
        $phone=$req->input('phone');
        $office_location=$req->input('office_location');

        return $this->repo->updateCounselors($id,$name,$email,$phone,$office_location);
    }


    // }
            //delete 
    public function deletecounselors(Request $req){
        Log::warning($req);
        $id=$req->input('id');
        return $this->repo->deletecounselors($id);
    }

    //  }
    //     //show All 
      public function showAllCounselors(Request $req){
        $search = $req->input('search', '');
         return $this->repo->showAllCounselors($search);
     }

    //   //show  data by Id
     public function listbyid(Request $req){
         $id=$req->input('id');
         return $this->repo->listbyId($id);
     }
}

