<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
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
            'token' => $user->createToken('API token for'.$user->email)->plainTextToken,
        ]);
    }

    public function register()
    {
        // 
    }
}
