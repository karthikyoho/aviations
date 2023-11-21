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


    public function updateStaff(Request $req){
        $staff_id = $req->input('staff_id');
        $staff_name = $req->input('staff_name');

        return $this->repo->updateStaff($staff_id,$staff_name);
    }

    public function deleteStaff(Request $req){
        $id = $req->input('id');
        return $this->repo->deleteStaff($id);
        
    }

    public function show(Request $req){
        $search=$req->input('search');
        return $this->repo->show($search);
    }

    public function status(Request $req){
        $id=$req->input('id');
        $status=$req->input('status');
        return $this->repo->status($id,$status);
    }

    public function getStaffById(Request $req){
        $id=$req->input('id');
        return $this->repo->getStaffById($id);
    }
    


}
