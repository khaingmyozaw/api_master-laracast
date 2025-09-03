<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use ApiResponse;
    public function login(LoginRequest $request)
    {
        $request->validated($request->all());

        if (!Auth::attempt($request->only('email', 'password'))) {
            return $this->error('Unauthenticated!', 401);
        }

        $user = User::firstWhere('email', $request->email);

        return $this->ok('You successfully logged in.', [
            'token' => $user->createToken(
                'API token for'.$user->email,
                ['*'],
                now()->addMonth()
                )->plainTextToken,
        ]);
    }

    public function register(RegisterRequest $request)
    {
        $request->validated($request->all());

        if (User::where('email', $request->email)->exists()) {
            return $this->error('You already have an account with this email.', 400);
        }

        $user = User::create($request->only('name', 'email', 'password'));

        Auth::login($user);

        return $this->success(
            'Account created successfully',
            [
                $user,
                'token'=> $user->createToken('Api token for'.$user->email)->plainTextToken,
            ],
            201
        );
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->ok('', [], 200);
    }
}
