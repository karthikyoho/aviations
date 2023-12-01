<?php

namespace App\Repositories\Student;

use App\Models\College;
use App\Repositories\BaseRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CollegeRepository implements BaseRepositoryInterface
{
    public function all()
    {
        //
    }

    public function create($name, $description, $address_line_1, $city, $phone, $state, $pincode, $alternate_number, $official_website, $facebook, $linkedin, $instagram, $twitter, $filePath, $gallery)
    {
        DB::beginTransaction();
        try {

            $id = "CLGID";
            $collegeId = self::generateUniqueCollegeId($id);
            $existingCollege = College::where('college_name', $name)
            ->where('is_deleted', 'no')
            ->first();
    
        if ($existingCollege) {
            return ["status" => false, "message" => "'$name' already exists"];
        }
    
            $college = College::create([
                'college_name' => $name,
                'college_id' => $collegeId,
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
                'phone' => $phone,
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
   
   
    public function update($req, $filePath, $gallery)
    {
        DB::beginTransaction();
        try {
            $collegeId = $req['id'];

            $college = College::where('id', $collegeId)->first();

            if (!$college) {
                DB::rollBack();
                return ["status" => false, "message" => "College not found"];
            }

            // Update college fields
            $updatableFields = [
                'college_name',
                'description',
                'address_line_1',
                'city',
                'state',
                'pincode',
                'alternate_number',
                'official_website',
                'facebook',         
                'linkedin',
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

            $college->save();
            DB::commit();
            return ["status" => true, "data" => $college, 'message' => 'College updated successfully'];
        } catch (\Exception $e) {
            Log::warning($e);
            DB::rollBack();
            return ["status" => false, 'message' => $e->getMessage()];
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

            $college = College::find($id)->update(['is_deleted' => 'yes']);
            DB::commit();
            return ["status" => true, "data" => [$college], "message" => "data deleted successfully"];
        } catch (Exception $th) {
            Log::warning($th);
            DB::rollBack();
            return ["status" => false, "message" => $th->getMessage()];
        }
    }

    public function show($search)
    {
        DB::beginTransaction();
        try {

            $college = College::where('is_deleted', 'no')->where('is_active', 'yes')->when($search, function ($query) use ($search) {
                $query->where('college_name', 'like', '%' . $search . '%');
            })->paginate(60);
            return ["status" => true, "data" => $college, "message" => "College data displayed successfully"];
        } catch (Exception $e) {
            Log::warning($e);
            DB::rollBack();
            return ["status" => false, "message" => $e->getMessage()];
        }
    }


    public function status($id, $status)
    {
        DB::beginTransaction();
        try {
            if (!$id) {
                DB::rollBack();
                return ["status" => false, "message" => "Id is mandatory"];
            }
            if (!$status) {
                DB::rollBack();
                return ["status" => false, "message" => "Status is mandatory"];
            }
    
            $college =College::find($id);
    
            if (!$college) {
                DB::rollBack();
                return ["status" => false, "message" => "Data not found"];
            }
     

            
            $college->update(['is_active' => $status]);
            $college->refresh();  
    
            DB::commit();
    
            return ["status" => true, "data" => [], "message" => "college status updated successfully"];
        } catch (Exception $th) {
            Log::warning($th);
            DB::rollBack();
            return ["status" => false, "message" => $th->getMessage()];
        }
    }

    public function getCollegeById($id)
    {
        DB::beginTransaction();
        try {
            if (!$id) {
                DB::rollBack();
                return ["status" => false, "message" => "id is mandatory"];
            }
            $college = DB::table('colleges')
                ->where('id', $id)
                ->where('is_deleted', 'no')
                ->where('is_active', 'yes')
                ->first();

            if (!$college) {
                DB::rollBack();
                return ["status" => false, "message" => "Id is invalid"];
            }

            DB::commit();
            return ["status" => true, "data" => $college, "message" => "college data fetched successfully"];
        } catch (Exception $e) {
            Log::warning($e);
            DB::rollBack();
            return ["status" => false, "message" => $e->getMessage()];
        }
    }
    private static function generateUniqueCollegeId($prefix)
    {
        // Find the maximum faq_module_id with the given prefix
        $maxId = College::where('college_id', 'like', $prefix . '%')->max('college_id');

        // Extract the numeric part, increment, and pad with zeros
        $numericPart = $maxId ? (int) substr($maxId, strlen($prefix)) + 1 : 1;
        $newId = $prefix . str_pad($numericPart, 4, '0', STR_PAD_LEFT);

        return $newId;
    }



    
}
