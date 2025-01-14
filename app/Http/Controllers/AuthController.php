<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //
    public function login(LoginUserRequest $request){
        $attempt = Auth::attempt($request->only('email', 'password'));
        if($attempt){
            $user = Auth::user();
            return response()->json([
                'success' => true,
                'message' => 'Login Successful',
                'token' => $user->createToken('MyApp')->plainTextToken,
            ], 202);
        }
        return response()->json([
            'success' => false,
            'message' => 'Login Failed',
        ], 402);
    }
    public function register(StoreUserRequest $request){
        $user = User::create($request->all());
        return response()->json([
            'success' => true,
            'message' => 'User created successfully',
            'token' => $user->createToken('MyApp')->plainTextToken
        ],201);
    }
    public function logout(){
        Auth::user()->currentAccessToken()->delete();
        return response()->json([
            'success' => true,
            'message' => 'Logout Successful',
        ]);
    }

}
