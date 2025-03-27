<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{
    protected AuthRepositoryInterface $authRepository;

    public function __construct(AuthRepositoryInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }


    public function register(array $data): ?array
    {
        $userData = $this->authRepository->createUser($data);

        $user = User::find($userData->id);
        if (!$user) {
            return null;
        }

        $token = JWTAuth::fromUser($user);

        return [
            'user'  => $user,
            'token' => $token,
        ];
    }

    public function login(array $credentials): ?array
    {
        $userData = $this->authRepository->findUserByEmail($credentials['email']);

        if (!$userData || !Hash::check($credentials['password'], $userData->password)) {
            return null;
        }

        $user = User::find($userData->id);
        if (!$user) {
            return null;
        }

        $token = JWTAuth::fromUser($user);

        return [
            'user'  => $user,
            'token' => $token,
        ];
    }

    public function logout(): bool
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            return true;
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return false;
        }
    }
}
