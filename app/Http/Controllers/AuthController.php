<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|string|email|max:255|unique:users',
            'password'              => 'required|string|min:6|',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $result = $this->authService->register($request->only('name', 'email', 'password'));

        if (!$result) {
            return response()->json(['error' => 'Registration failed'], 500);
        }

        return response()->json($result, 201);
    }
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $result = $this->authService->login($credentials);

        if (!$result) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json($result);
    }

    public function logout(Request $request)
    {
        $result = $this->authService->logout();

        if (!$result) {
            return response()->json(['error' => 'Logout failed'], 500);
        }

        return response()->json(['message' => 'Successfully logged out']);
    }
}
