<?php

namespace App\Http\Controllers\Staff\StaffManagement;

use App\Http\Controllers\Controller;
use App\Repositories\ImageRepository;
use App\Repositories\Staff\StaffRepository;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    protected $repo;
    protected $img;
    public function __construct(StaffRepository $repo, ImageRepository $img)
    {
        $this->repo = $repo;
        $this->img = $img;
    }


    public function staffCreate(Request $req){
        $college_id = $req->input('college_id');
        $staff_name = $req->input('staff_name');
        return $this->repo->staffCreate($college_id,$staff_name);
    }


}
