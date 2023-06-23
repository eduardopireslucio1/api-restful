<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthLoginRequest;
use Illuminate\Http\Request;
use App\Http\Requests\AuthRegisterRequest;
use App\Services\AuthService;
use App\Http\Resources\UserResource;

class AuthController extends Controller
{
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(AuthRegisterRequest $request)
    {
        $input = $request->validated();
        // Valida os dados da requisição com base nas regras definidas em AuthRegisterRequest

        $user = $this->authService->register($input);
        // Chama o serviço AuthService para registrar um novo usuário com base nos dados validados

        return new UserResource($user);
        // Retorna o usuário registrado
    }

    public function login(AuthLoginRequest $request)
    {
        $input = $request->validated();
        // Valida os dados da requisição com base nas regras definidas em AuthLoginRequest

        $token = $this->authService->login($input);
        // Chama o serviço AuthService para fazer login e obter o token de autenticação

        return (new UserResource(auth()->user()))->additional($token);
        // Retorna o usuário autenticado e adiciona o token como dados adicionais
    }
}