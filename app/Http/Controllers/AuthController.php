<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
   public function register( RegisterUserRequest $request)
   {
     $register = $request->all();

     $user = User::create([
            'name' => $register['name'],
            'username' => $register['username'],
            'password' => bcrypt($register['password'])
        ]);
        $token = $user->createToken('main')->plainTextToken;

     return response([
            'user' => $user,
            'token' => $token,
        ]);
   }
   public function login(LoginUserRequest $request)
   {

        $credentials = $request->all();

        $user = User::where('username', $credentials['username'])->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $token = $user->createToken('main')->plainTextToken;
        return response([
            'user' => $user,
            'token' => $token,
        ]);
    }



   public function logout()
   {
        /** @var User */
        Auth::logout(true);
        return response([
            'success' => true,
        ]);
   }
}
