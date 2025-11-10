<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Credenciais inválidas'], 401);
        }

        $user = Auth::user();

        $user  = new UserResource($user);

        $token = $user->createToken('auth_token')->plainTextToken;

        // Criar cookie HttpOnly com 1 hora de expiração
        // $cookie = cookie(
        //     'auth_token',      // nome do cookie
        //     $token,            // valor
        //     60*5,                // duração em minutos
        //     null,
        //     null,
        //     false,              // Secure (somente https)
        //     true,              // HttpOnly,
        //     false,
        //     'None'
        // );

        return response()->json(['message' => 'Login efetuado com sucesso', 'token' => $token, 'user' => $user], 200);
        //->withCookie($cookie);

    }

    public function store(UserRequest $request)
    {
        DB::beginTransaction();

        try {
            $data = $request->all();

            if ($data['photo']) {
                $data['photo'] = $request->file('photo')->store('users', 'r2');
            }

            User::create([
                "name" => $data['name'],
                "email" => $request['email'],
                "password" => Hash::make($request['password']),
                "photo" => $data['photo'] ?? null,
                "birthdate" => $data['birthdate'],
                "autodescription" => $data['autodescription'],

            ]);

            DB::commit();

            return response()->json([
                'message' => 'Usuário criado com sucesso',
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 403);
        }
    }

    public function logout()
    {
        $cookie = Cookie::forget('auth_token');
        return response()->json(['message' => 'Logout efetuado com sucesso'])
            ->withCookie($cookie);
    }
}
