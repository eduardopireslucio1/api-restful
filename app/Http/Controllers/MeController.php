<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;

class MeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api'); // Middleware para exigir autenticação nas rotas da API
    }

    /**
     * @OA\get(
     *      path="/liberfly/me",
     *      operationId="getMe",
     *      tags={"Me"},
     *      summary="Get Me",
     *      security={{"bearerAuth":{}}},
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

    public function index()
    {
        // Retorna o usuário autenticado
        return new UserResource(auth()->user());
    }
}
