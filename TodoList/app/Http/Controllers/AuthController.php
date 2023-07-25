<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request) {
        $validatedData = $request->validated();

        $validatedData['password'] = bcrypt($request->password);

        $user = User::create($validatedData);

        $accessToken = $user->createToken('API Token')->accessToken;

        return response(['user' => $user, 'access_token' => $accessToken], 201);
    }

    public function login(LoginRequest $request) {

        $validatedData = $request->validated();
        $user = User::where('email', $validatedData['email'])->first();

        if (!$user || !Hash::check($validatedData['password'], $user->password)) {
            return response(['errors' => ['message' => 'Invalid credentials']], 422);
        }
        return response(['user' => $user, 'access_token' => $user->createToken('API Token')->accessToken], 200);
    }
}
