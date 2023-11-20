<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Student extends Model
{
    use HasFactory;
    protected $guarded = [];

    
       
    
        
        public static function boot()
        {
            parent::boot();
    
            static::creating(function ($student) {
                if (!$student->college_id) {
                    $student->student_id  = self::generateUniqueCollegeId(strtoupper($student->first_name));
                }
            });
        }
    
        // Generate a unique 'college_id'
        public static function generateUniqueCollegeId($name)
        {
            $studentPrefix = Str::slug($name) . "01";
            $studentPrefix = strtoupper($studentPrefix);
            return $studentPrefix;
        }
    
    






    
}
