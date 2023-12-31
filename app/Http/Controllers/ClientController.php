<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Http\Requests\ClientStoreRequest;
use App\Http\Resources\ClientResource;
use App\Http\Requests\ClientUpdateRequest;
use App\Policies\ClientPolicy;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="API Liberfly",
 *     version="1.0"
 * )
 */

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api'); // Middleware para exigir autenticação nas rotas da API
    }

    /**
     * @OA\Get(
     *      path="/liberfly/clients",
     *      operationId="getClientList",
     *      tags={"Clients"},
     *      summary="Get list of clients",
     *      security={{"bearerAuth":{}}},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(
     *                  @OA\Property(property="id", type="integer"),
     *                  @OA\Property(property="name", type="string"),
     *                  @OA\Property(property="phone", type="string"),
     *                  @OA\Property(property="address", type="string"),
     *                  @OA\Property(property="email", type="string"),
     *                  @OA\Property(property="created_at", type="string")
     *              )
     *          )
     *      )
     * )
     */
    public function index()
    {
        return ClientResource::collection(auth()->user()->clients);
        // Retorna uma collection de Clientes pertencentes ao usuário autenticado
    }

    /**
     * @OA\Get(
     *      path="/liberfly/clients/{id}",
     *      operationId="getClient",
     *      tags={"Clients"},
     *      summary="Get information from a specific client",
     *      security={{"bearerAuth":{}}},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(
     *                  @OA\Property(property="id", type="integer"),
     *                  @OA\Property(property="name", type="string"),
     *                  @OA\Property(property="phone", type="string"),
     *                  @OA\Property(property="address", type="string"),
     *                  @OA\Property(property="email", type="string"),
     *                  @OA\Property(property="created_at", type="string")
     *              )
     *          )
     *      )
     * )
     */
    public function show(Client $client)
    {
        $this->authorize('view', $client);
        // Verifica se o usuário autenticado está autorizado a visualizar o cliente fornecido

        return new ClientResource($client);
        // Retorna o cliente
    }

    /**
     * @OA\Post(
     *      path="/liberfly/clients/",
     *      operationId="createClient",
     *      tags={"Clients"},
     *      summary="Create a new Client",
     *      security={{"bearerAuth":{}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="name", type="string"),
     *              @OA\Property(property="email", type="string"),
     *              @OA\Property(property="phone", type="string"),
     *              @OA\Property(property="address", type="string")
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="id", type="integer"),
     *              @OA\Property(property="name", type="string"),
     *              @OA\Property(property="phone", type="string"),
     *              @OA\Property(property="address", type="string"),
     *              @OA\Property(property="email", type="string"),
     *              @OA\Property(property="created_at", type="string")
     *          )
     *      )
     * )
     */
    public function store(ClientStoreRequest $request)
    {
        $input = $request->validated();
        // Valida os dados da requisição com base nas regras definidas em ClientStoreRequest

        $client = auth()->user()->clients()->create($input);
        // Cria um novo cliente associado ao usuário autenticado com base nos dados validados

        return new ClientResource($client);
        // Retorna o cliente
    }

    /**
     * @OA\Put(
     *      path="/liberfly/clients/{id}",
     *      operationId="updateClient",
     *      tags={"Clients"},
     *      summary="Update a specific client",
     *      security={{"bearerAuth":{}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="phone", type="string"),
     *              @OA\Property(property="address", type="string")
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="id", type="integer"),
     *              @OA\Property(property="name", type="string"),
     *              @OA\Property(property="phone", type="string"),
     *              @OA\Property(property="address", type="string"),
     *              @OA\Property(property="email", type="string"),
     *              @OA\Property(property="created_at", type="string")
     *          )
     *      )
     * )
     */
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

    /**
     * @OA\Delete(
     *      path="/liberfly/clients/{id}",
     *      operationId="deleteClient",
     *      tags={"Clients"},
     *      summary="Delete a specific client",
     *      security={{"bearerAuth":{}}},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *      )
     * )
     */
    public function destroy(Client $client)
    {
        $this->authorize('destroy', $client);
        // Verifica se o usuário autenticado está autorizado a excluir o cliente fornecido

        $client->delete();
        // Exclui o cliente do banco de dados
    }
}
