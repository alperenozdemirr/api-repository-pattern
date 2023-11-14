<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthLoginRequest;
use App\Http\Requests\Auth\AuthRegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function register(AuthRegisterRequest $request){
        //user create
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password'])
        ]);
        return response(['message'=>'user create successfully.','users'=>UserResource::make($user)], 201);
    }

    public function login(AuthLoginRequest $request) {

        // Check email
        $user = User::where('email', $request->email)->first();

        // Check password
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response(['message' => 'Invalid credentials'], 401);
        }
        //create token
        $token = $user->createToken('user-token')->plainTextToken;
        //set token and user info
        return response(['message'=>'user create successfully.','users'=>UserResource::make($user),'token'=>$token], 201);
    }

    public function logout(Request $request) {
        auth()->user()->tokens()->delete();
        return response(['logout'=>'logged out'], 201);
    }
}
