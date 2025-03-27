<?php

namespace App\Repositories;

use App\Repositories\Interfaces\AuthRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthRepository implements AuthRepositoryInterface
{
    public function createUser(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        $id = DB::table('users')->insertGetId([
            'name'       => $data['name'],
            'email'      => $data['email'],
            'password'   => $data['password'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return DB::table('users')->where('id', $id)->first();
    }
    public function findUserByEmail(string $email)
    {
        return DB::table('users')->where('email', $email)->first();
    }
}
