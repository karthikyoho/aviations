<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class College extends Model
{
    use HasFactory;
    protected $guarded=[];

    
    public static function boot()
    {
        parent::boot();

        static::creating(function ($college) {
            if (!$college->college_id) {
                $college->college_id = self::generateUniqueCollegeId(strtoupper($college->college_name));
            }
        });
    }

    // Generate a unique 'college_id'
    public static function generateUniqueCollegeId($name)
    {
        $collegePrefix = Str::slug($name) . "CLGID01";
        $collegePrefix = strtoupper($collegePrefix);
        return $collegePrefix;
    }

}
