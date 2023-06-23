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

    /**
     * @OA\Post(
     *      path="/liberfly/register",
     *      operationId="createUser",
     *      tags={"Auth"},
     *      summary="User register",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="name", type="string"),
     *              @OA\Property(property="email", type="string"),
     *              @OA\Property(property="password", type="string"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(
     *                  @OA\Property(property="id", type="integer"),
     *                  @OA\Property(property="name", type="string"),
     *                  @OA\Property(property="email", type="string"),
     *                  @OA\Property(property="created_at", type="string")
     *              )
     *          )
     *      )
     * )
     */
    public function register(AuthRegisterRequest $request)
    {
        $input = $request->validated();
        // Valida os dados da requisição com base nas regras definidas em AuthRegisterRequest

        $user = $this->authService->register($input);
        // Chama o serviço AuthService para registrar um novo usuário com base nos dados validados

        return new UserResource($user);
        // Retorna o usuário registrado
    }


    /**
     * @OA\Post(
     *      path="/liberfly/login",
     *      operationId="logginUser",
     *      tags={"Auth"},
     *      summary="User login",
     *       @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="email", type="string"),
     *              @OA\Property(property="password", type="string"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(
     *                  @OA\Property(property="id", type="integer"),
     *                  @OA\Property(property="name", type="string"),
     *                  @OA\Property(property="email", type="string"),
     *                  @OA\Property(property="created_at", type="string"),
     *                  @OA\Property(property="access_token", type="string"),
     *                  @OA\Property(property="token_type", type="string")
     *              )
     *          )
     *      )
     * )
     */
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
