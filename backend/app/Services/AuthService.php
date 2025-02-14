<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Exceptions\HttpResponseException;
use Tymon\JWTAuth\Facades\JWTAuth;


class AuthService
{    public function register(array $data)
    {
        try {
            $user = User::create([
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            return $user;
        } catch (QueryException $e) {
            throw $e;
        }
    }

    public function login(array $data)
    {
        try {
            $user = User::where('email', $data['email'])->first();

            if (!$user || !Hash::check($data['password'], $user->password)) {
                throw new HttpResponseException(response()->json([
                    'message' => 'Email ou senha inválidos.',
                ], 400));
             }
             $token = JWTAuth::fromUser($user);

            return $token;

        } catch (QueryException $e) {
            throw $e;
        }
    }



}
