<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // for register
    public function register(Request $request)
    {
        // validation for registering user
        Validator::make($request->all(),
        [
            'name' => 'required|string|max:30',
            'email' => 'required|email:dns|unique:users,email',
            'password' => 'required|min:6|max:20'

        ],[])->validate();

        // store user data to db and get user data back
        $user = User::create(
        [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // create user token on registering user
        $registerToken = $user->createToken('registerToken');

        // response user token and message
       return ResponseHelper::response(data: ['access_token' => $registerToken->plainTextToken],message: 'Registering Success');
    }


    // for login
    public function login(Request $request)
    {
        // validation for registering user
        Validator::make($request->all(),
        [
            'email' => 'required|email:dns',
            'password' => 'required'
        ],[])->validate();

        // chech login info and if right create login token
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

            $user = Auth::user();
            $loginToken = $user->createToken('loginToken');

            // response user token and message
            return ResponseHelper::response(data: ['access_token' => $loginToken->plainTextToken],message: 'Login Success');
        }
    }


    // for logout

    public function logout()
    {
        Auth::user()->currentAccessToken()->delete();
        return ResponseHelper::response(message: 'Successfully Logout.');
    }

}
