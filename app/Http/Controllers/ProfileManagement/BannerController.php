<?php

namespace App\Http\Controllers\ProfileManagement;

use App\Http\Controllers\Controller;
use App\Repositories\ImageRepository;
use App\Repositories\Student\BannerRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BannerController extends Controller
{
   
    protected $repo;
    protected $img;
    public function __construct(BannerRepository $repo,ImageRepository $img)
    {
      $this->repo=$repo;
      $this->img=$img;
    }

    public function create(Request $req)
    {
        try {
            Log::warning($req);
    
            $title = $req->input('title');
            $description = $req->input('description');
    
            $BannerImgPath = "assets/banner/image";
            $filePaths = [];
    
            if ($req->hasFile('image_path')) {
                foreach ($req->file('image_path') as $file) {
                    $filePath = $this->img->uploadImage($file,$BannerImgPath);
    
                    if (!empty($filePath)) {
                        $filePaths[] = $filePath;
                    } else {
                        Log::error('File upload failed.');
                    }
                }
            }
    
            // Ensure that $filePaths is an array, even if it's empty
            $filePaths = is_array($filePaths) ? $filePaths : [];
    
            return $this->repo->create($title, $description, $filePaths);
        } catch (Exception $e) {
            Log::error('Error in create method: ' . $e->getMessage());
            // Handle the exception as needed
        }
    }
    
    public function update(Request $req){
        Log::warning($req);
        $id=$req->input('id');
        $title = $req->input('title');
        $description = $req->input('description');
        $filePath = "assets/banner/image";
        $filePath = "";
        if ($req->hasFile('image')) {
            $filePath = $this->img->uploadImage($req->file('image'), $filePath);
        }
        return $this->repo->update($id,$title,$description,$filePath);
    }

    public function delete(Request $req){
        Log::warning($req);
        $id=$req->input('id');
    return $this->repo->delete($id);
    }

    public function getall(Request $req){
        Log::warning($req);
        $search=$req->input('search');
    return $this->repo->getAll($search);
    }

    public function status(Request $req ){
        Log::warning($req);
        $id=$req->input('id');
        $status=$req->input('status');
        return $this->repo->status($id,$status);
    }

    public function getbyid(Request $req){
        Log::warning($req);
        $id=$req->input('id');
        return $this->repo->listById($id);
    }
 


}
