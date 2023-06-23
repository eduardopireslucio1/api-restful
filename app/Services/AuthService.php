<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Str;
use App\Exceptions\UserHasBeenTakenException;
use App\Exceptions\LoginInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{
    public function register(array $input)
    {
        $userExists = User::where('email', $input['email'])->exists();
        // Verifica se já existe um usuário com o mesmo e-mail

        if ($userExists) {
            throw new UserHasBeenTakenException();
            // Lança uma exceção personalizada se o usuário já estiver sido registrado
        }

        $userPassword = bcrypt($input['password'] ?? Str::random(10));
        // Criptografa a senha do usuário ou gera uma senha aleatória

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => $userPassword,
        ]);
        // Cria um novo usuário com base nos dados fornecidos

        return $user;
        // Retorna o usuário registrado
    }

    public function login(array $input)
    {
        $login = [
            'email' => $input['email'],
            'password' => $input['password'],
        ];
        // Credenciais de login (e-mail e senha)

        if (!auth()->attempt($login)) {
            throw new LoginInvalidException();
            // Lança uma exceção personalizada se as credenciais de login forem inválidas
        }

        $user = auth()->user();
        // Obtém o usuário autenticado

        $token = JWTAuth::fromUser($user);
        // Gera o token de acesso JWT para o usuário autenticado

        return [
            'access_token' => $token,
            'token_type' => 'Bearer',
        ];
        // Retorna o token de acesso com o tipo "Bearer"
    }
}
