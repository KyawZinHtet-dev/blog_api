<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TestController extends Controller
{
    // public function register(Request $request)
    // {
    //     $user = User::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'password' => Hash::make($request->password),
    //     ]);

    //     $userToken = $user->createToken('userToken');

    //     return response()->json([
    //         'status' => 200,
    //         'message' => 'Successfully Registered',
    //         'token' => $userToken->plainTextToken,
    //     ]);
    // }

    
    // public function login(Request $request)
    // {  
    //     Auth::attempt(['email' => $request->email, 'password' => $request->password]);

    //     $user = Auth::user();
        
    //     $userToken = $user->createToken('userToken');

    //     return response()->json([
    //         'status' => 200,
    //         'message' => 'Successfully Login',
    //         'token' => $userToken->plainTextToken,
    //     ]);
    // }

    // public function getUserDate()
    // {
    //     return Auth::user();
    // }
}
