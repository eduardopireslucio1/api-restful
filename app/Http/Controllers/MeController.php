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

    public function index()
    {
        // Retorna o usuário autenticado
        return new UserResource(auth()->user());
    }

}
