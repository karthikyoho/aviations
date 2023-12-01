<?php

namespace App\Repositories\Student;

use App\Models\Banner;
use App\Repositories\BaseRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class BannerRepository implements BaseRepositoryInterface
{
    public function all()
    {
    }
    public function create($title, $description, $filePaths)
    {
        DB::beginTransaction();
    
        try {
            if (!$title || !$description) {
                DB::rollBack();
                return ["status" => false, "message" => "Title and description are mandatory"];
            }
    
            $imagePathJson = json_encode($filePaths);
    
            if ($imagePathJson === false) {
                // Handle json_encode failure
                DB::rollBack();
                return ["status" => false, "message" => "Failed to encode image paths to JSON"];
            }    
    
            $banner = Banner::create([
                'title' => $title,
                'description' => $description,
                'image_path' => $imagePathJson,
            ]);
    
            DB::commit();
    
            return ["status" => true, "data" => [$banner], "message" => "Data added successfully"];
        } catch (Exception $e) {
            Log::warning($e);
            DB::rollBack();
            return ["status" => false, "message" => $e->getMessage()];
        }
    }

    public function update($id, $title, $description, $filePath)
    {
        DB::beginTransaction();
        try {
            if (!$id) {
                DB::rollback();
                return ["status" => false, "message" => "id is mandatory"];
            }

            $banner = Banner::find($id);

            if (!$banner) {
                DB::rollback();
                return ["status" => false, "message" => "data not available"];
            }

           
            if ($title) {
                $banner->title = $title;
            }
            if ($description) {
                $banner->description = $description;
            }
            if ($filePath) {
                $banner->images = $filePath;
            }

            $banner->save();
 
            DB::commit();

            return ["status" => true, "message" => "$id updated successfully"];
        } catch (Exception $e) {
            Log::warning($e);
            DB::rollBack();     
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
            $deletebanners = Banner::where('id', $id)->where('is_deleted', 'no')->get();
            if (!count($deletebanners)) {
                DB::rollBack();
                return response()->json(["message" => "department id not found"]);
            }
            $deletebanners = Banner::where('id', $id)->update(['is_deleted' => 'yes']);
            // DB::select( $deleteQuerry);
            DB::commit();
            return ["status" => true, "data" => $deletebanners, "message" => "Banner deleted sucessfully"];
        } catch (Exception $th) {
            Log::warning($th);
            DB::rollBack();
            return ["status" => false, "message" => $th->getMessage()];
        }
    }

    public function getAll($search)
    { 
            try {
              
                $getallbanner = Banner::where('is_deleted', 'no')->when($search, function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                })->paginate(60);
                return ["status" => true, "data" => $getallbanner, "message" => " banner data list successfully"];
            } catch (Exception $e) {
                Log::warning($e);
                return ["status" => false, "message" => $e->getMessage()];
            }
        }

        public function status($id, $status)
        {
            DB::beginTransaction();
            try {
    
                     if (!$id) {
                         DB::rollBack();
                         return ["return" => false, "message" => " ID is mandatory"];
                     }
                     
                     if (!$status) {
                        DB::rollBack();
                        return ["return" => false, "message" => "Status is mandatory"];
                    }
    
              
                // update Active status using RawQuery
                $updateQuery = "update Banners set is_active='$status' where id=$id ";
                DB::select($updateQuery);
                DB::commit();
                return ["status" => true, "data" => [], "message" => " active status is upadated successfully"];
            } catch (Exception $th) {
                Log::warning($th); 
                DB::rollBack();
                return ["status" => false, "message" => $th->getMessage()];
            }
        }


        public function listById($id)
        {
            DB::beginTransaction();
            try {
                if (!$id) {
                    DB::rollBack();
                    return ["status" => false, "message" => "id is mandatory"];
                }
                $banner = Banner::
                    where('id', $id)
                    ->where('is_deleted', 'no')
                    ->where('is_active', 'yes')
                    ->first();
    
                if (!$banner) {
                    DB::rollBack();
                    return ["status" => false, "message" => "Id is invalid"];
                }
    
                DB::commit();
                return ["status" => true, "data" => $banner, "message" => "banners data fetched successfully"];
            } catch (Exception $e) {
                Log::warning($e);
                DB::rollBack();
                return ["status" => false, "message" => $e->getMessage()];
            }
        }
    
    



    }
   


    
    
