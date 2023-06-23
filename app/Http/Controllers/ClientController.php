<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Http\Requests\ClientStoreRequest;
use App\Http\Resources\ClientResource;
use App\Http\Requests\ClientUpdateRequest;
use App\Policies\ClientPolicy;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api'); // Middleware para exigir autenticação nas rotas da API
    }

    public function index()
    {
        return ClientResource::collection(auth()->user()->clients);
        // Retorna uma collection de Clientes pertencentes ao usuário autenticado
    }

    public function show(Client $client)
    {
        $this->authorize('view', $client);
        // Verifica se o usuário autenticado está autorizado a visualizar o cliente fornecido

        return new ClientResource($client);
        // Retorna o cliente
    }

    public function store(ClientStoreRequest $request)
    {
        $input = $request->validated();
        // Valida os dados da requisição com base nas regras definidas em ClientStoreRequest

        $client = auth()->user()->clients()->create($input);
        // Cria um novo cliente associado ao usuário autenticado com base nos dados validados

        return new ClientResource($client);
        // Retorna o cliente
    }

    public function update(Client $client, ClientUpdateRequest $request)
    {
        $this->authorize('update', $client);
        // Verifica se o usuário autenticado está autorizado a atualizar o cliente fornecido

        $input = $request->validated();
        // Valida os dados da requisição com base nas regras definidas em ClientUpdateRequest

        $client->fill($input)->save();
        // Preenche o cliente com os novos dados e salva no banco de dados

        return new ClientResource($client->fresh());
        // Retorna o cliente atualizado 
    }

    public function destroy(Client $client)
    {
        $this->authorize('destroy', $client);
        // Verifica se o usuário autenticado está autorizado a excluir o cliente fornecido

        $client->delete();
        // Exclui o cliente do banco de dados
    }
}
