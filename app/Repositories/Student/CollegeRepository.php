<?php

namespace App\Repositories\Student;

use App\Models\College;
use App\Repositories\BaseRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CollegeRepository implements BaseRepositoryInterface
{
    public function all()
    {
       //
    }

    public function create($name, $description, $address_line_1, $city, $phone,$state, $pincode, $alternate_number, $official_website, $facebook, $linkedin, $instagram, $twitter, $filePath, $gallery)
    {
        DB::beginTransaction();
        try {

            $college = College::create([
                'college_name' => $name,
                'description' => $description,
                'address_line_1' => $address_line_1,
                'city' => $city,
                'state' => $state,
                'pincode' => $pincode,
                'alternate_number' => $alternate_number,
                'official_website' => $official_website,
                'facebook' => $facebook,
                'linkedin' => $linkedin,
                'instagram' => $instagram,
                'twitter' => $twitter,
                'logo' => $filePath,
                'phone'=>$phone,
                'gallery' => json_encode($gallery),
            ]);


            
            $college->save();
            DB::commit();
            return ["status" => true, "data" => $college, 'message' => 'College created successfully'];
        } catch (\Exception $e) {
            Log::warning($e);
            DB::rollBack();
            return ["status" => false, 'message' => $e->getMessage()];
        }
    }

    public function update($id, $name, $description, $address_line_1, $city, $phone, $state, $pincode, $alternate_number, $official_website, $facebook, $linkedin, $instagram, $twitter, $filePath, $gallery)
    {
        DB::beginTransaction();
        try {
            $collegeId = $request['id'];

            $college = College::where('id', $collegeId)->first();

            if (!$college) {
                DB::rollBack();
                return ["status" => false, "message" => "College not found"];
            }

            // Update college fields
            $updatableFields = [
                'college_name',
                'description' ,
                'address_line_1' ,
                'city',
                'state',
                'pincode',
                'alternate_number',
                'official_website' ,
                'facebook',
                'linkedin' ,
                'instagram',
                'twitter',
                'phone',
                
              
            ];

            $collegeData = [];
            foreach ($updatableFields as $field) {
                if (isset($request[$field])) {
                    $collegeData[$field] = $request[$field];
                }
            }
            if (isset($request['logo'])) {
                $collegeData['logo'] = $filePath;
            }

            if (isset($request['gallery'])) {
                $collegeData['gallery'] = $gallery;
            }

            DB::commit();
            return ["status" => true, "data" => $college, 'message' => 'College updated successfully'];
        } catch (\Exception $e) {
            Log::warning($e);
            DB::rollBack();
            return ["status" => false, 'message' => $e->getMessage()];
        }
    }
    public function delete($id){
        DB::beginTransaction();
        try{
            if(!$id){
                DB::rollBack();
                return ["status"=>false, "message"=>"id is mandatory"];
            }

            $college=College::find($id)->update(['is_deleted'=>'yes']);
            DB::commit();
            return ["status" => true, "data" => [$college], "message" => "deleted successfully"];
        } catch (Exception $th) {
            Log::warning($th);
            DB::rollBack();
            return ["status" => false, "message" => $th->getMessage()];
        }
        }
    }
