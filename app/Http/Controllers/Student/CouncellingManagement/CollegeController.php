<?php

namespace App\Http\Controllers\Student\CouncellingManagement;

use App\Http\Controllers\Controller;
use App\Repositories\ImageRepository;
use App\Repositories\Student\CollegeRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CollegeController extends Controller
{
    protected $repo;
    protected $img;
    public function __construct(CollegeRepository $repo,ImageRepository $img)
    {
      $this->repo=$repo;
      $this->img=$img;
    }
     
    //create College
    public function create(Request $req)
    {
        try {
            $name = $req->input('college_name');
            $description = $req->input('description');
            $address_line_1 = $req->input('address_line_1');
            $city = $req->input('city');
            $state = $req->input('state');
            $pincode = $req->input('pincode');
            $phone=$req->input('phone');
            $alternate_number = $req->input('alternate_number');
            $official_website = $req->input('official_website');
            $facebook = $req->input('facebook');
            $linkedin = $req->input('linkedin');
            $instagram = $req->input('instagram');
            $twitter = $req->input('twitter');
         

            $CollegeImgPath = "assets/college_management/college/image";
            $filePath = "";
            if ($req->hasFile('logo')) {
                $filePath = $this->img->uploadImage($req->file('logo'), $CollegeImgPath);
            }

            $CollegeGalleryPath = "assets/college_management/college/gallery";
            $gallery = [];
            if ($req->hasFile('gallery')) {
                $galleryFiles = $req->file('gallery');
                foreach ($galleryFiles as $galleryFile) {
                    $gallery[] = $this->img->uploadImage($galleryFile, $CollegeGalleryPath);
                }
            }

            $result = $this->repo->create($name, $description, $address_line_1,$phone, $city, $state, $pincode, $alternate_number, $official_website, $facebook, $linkedin, $instagram, $twitter, $filePath, $gallery);

            return response()->json($result);

        } catch (\Exception $e) {
            return response()->json(["status" => false, 'message' => $e->getMessage()], 500);
        }
    }

       //update College By Id
       public function update(Request $req) {
        Log::warning($req);
        try {
            $validator = Validator::make($req->all(), [
                'id' => 'required|string',
                'college_name' => 'nullable',
                'description' => 'nullable',
                'address_line_1' => 'nullable',
                'city' => 'nullable',
                'state' => 'nullable',
                'pincode' => 'nullable',
                'alternate_number' => 'nullable',
                'official_website' => 'nullable',
                'facebook' => 'nullable',
                'linkedin' => 'nullable',
                'instagram' => 'nullable',
                'twitter' => 'nullable',
                'phone' => 'nullable',
            ]);
    
            // Validate file inputs
            if ($req->hasFile('logo')) {
                $validator->addRules(['logo' => 'image|mimes:jpeg,png,jpg,gif']);
            }
    
            if ($req->hasFile('gallery')) {
                $validator->addRules(['gallery.*' => 'image|mimes:jpeg,png,jpg,gif']);
            }
    
            $validator->validate();
    
            $CollegeImgPath = "assets/college_management/college/image";
            $filePath = "";
            if ($req->hasFile('logo')) {
                $filePath = $this->img->uploadImage($req->file('logo'), $CollegeImgPath);
            }
    
            $CollegeGalleryPath = "assets/college_management/college/gallery";
            $gallery = [];
            if ($req->hasFile('gallery')) {
                $galleryFiles = $req->file('gallery');
                foreach ($galleryFiles as $galleryFile) {
                    $gallery[] = $this->img->uploadImage($galleryFile, $CollegeGalleryPath);
                }
            }
    
            $result = $this->repo->update($req->all(), $filePath, $gallery);
    
            return response()->json($result);
    
        } catch (\Exception $e) {
            return response()->json(["status" => false, 'message' => $e->getMessage()], 500);
        }
    }
        //delete College By id
    public function delete(Request $req){
        Log::warning($req);
        $id=$req->input('id');
    return $this->repo->delete($id);
    }
    
       //display All colleges
    public function show(Request $req){
        Log::warning($req);
        $search=$req->input('search');
    return $this->repo->show($search);
    }

        //update College status
    public function status(Request $req ){
        Log::warning($req);
        $id=$req->input('id');
        $status=$req->input('status');
        return $this->repo->status($id,$status);
    }

        //display College By Id
    public function getCollegeById(Request $req){
        Log::warning($req);
        $id=$req->input('id');
        return $this->repo->getCollegeById($id);
    }


}
