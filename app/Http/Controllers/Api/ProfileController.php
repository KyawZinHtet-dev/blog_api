<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ProfileResource;

class ProfileController extends Controller
{
    // return user data
    public function profile()
    {
        $user = Auth::user();
        
        return ResponseHelper::response(new ProfileResource($user)); // single data

        //ProfileResource::collection($user); multi data
    }
}
