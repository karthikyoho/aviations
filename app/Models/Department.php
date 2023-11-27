<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Department extends Model
{
    use HasFactory;
    protected $guarded = [];
    public static function boot()
    {
        parent::boot();

        static::creating(function ($department) {
            if (!$department->department_id) {
                $department->department_id = self::generateUniqueDepartmentId(strtoupper($department->name));
            }
        });
    }

    // Generate a unique 'college_id'
    public static function generateUniqueDepartmentId($name)
    {
        $departmentPrefix = Str::slug($name) . "DEPTID01";
        $departmentPrefix = strtoupper($departmentPrefix);
        return $departmentPrefix;
    }


}





