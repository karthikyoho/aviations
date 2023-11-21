<?php

namespace App\Http\Controllers\ProfileManagement;

use App\Http\Controllers\Controller;
use App\Repositories\Student\ProfileRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    protected $repo;

    public function __construct(ProfileRepository $repo)
    {
      $this->repo=$repo;
      
    }

    public function getStudentByUserId(Request $req){
        Log::warning($req);
        $user_id=$req->input('id');
        return $this->repo->getStudentByUserId($user_id);

    }
     
}
