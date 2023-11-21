<?php

namespace App\Repositories\Student;


use App\Repositories\BaseRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class BannerRepository implements BaseRepositoryInterface
{
    public function all()
    {
    }
}