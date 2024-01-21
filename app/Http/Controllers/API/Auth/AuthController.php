<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthLoginRequest;
use App\Http\Requests\Auth\AuthRegisterRequest;
use App\Http\Requests\Public\PasswordRequest;
use App\Http\Resources\User\UserResource;
use App\Jobs\NewUserMailJob;
use App\Mail\NewUserMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Queue\Jobs\Job;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{

    /**
     * @param AuthRegisterRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function register(AuthRegisterRequest $request){
        //user create
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password'])
        ]);
        if ($user){
            dispatch(new NewUserMailJob($request['name'], $request['email']));
            return response(['message'=>'user create successfully.','users'=>UserResource::make($user)], 201);
        }
        return response(['error'=>'Error occurred while processing the registration. Please check your information.'], 201);

    }

    /**
     * @param AuthLoginRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
     */
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

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function logout(Request $request) {
        auth()->user()->tokens()->delete();
        return response(['logout'=>'logged out'], 201);
    }

    /**
     * @param PasswordRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changePassword(PasswordRequest $request)
    {
        $user = Auth::user();
        if (!$user || !Hash::check($request->old_password, $user->password)) {
            return response()->json(['error' => 'The provided old password is incorrect.'], 422);
        }
        $user->update([
            'password' => bcrypt($request->new_password),
        ]);
        if ($user) {
            return response()->json(['message' => 'Password has been successfully changed'], 200);
        }
        return response()->json(['error','Failed to updated the password'],200);
    }
}
