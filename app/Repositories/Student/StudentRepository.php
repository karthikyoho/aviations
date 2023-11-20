<?php

namespace App\Repositories\Student;

use App\Models\Student;
use App\Models\User;
use App\Repositories\BaseRepositoryInterface;

class StudentRepository implements BaseRepositoryInterface
{
    public function all()
    {

    }

    public function create(array $data)
    {
        // You can customize this method based on your model and database structure
        return Student::create($data);
    }











    















}