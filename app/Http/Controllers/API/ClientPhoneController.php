<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateClientPhone;
use App\Services\Contracts\ClientServiceContract;
use Illuminate\Http\JsonResponse;

class ClientPhoneController extends Controller
{
    private ClientServiceContract $clientService;

    public function __construct(ClientServiceContract $clientService)
    {
        $this->clientService = $clientService;
    }

    /**
     *
     * @param integer $clientId
     * @return JsonResponse
     */
    public function index(int $clientId): JsonResponse
    {
        $phones = $this->clientService->clientPhones($clientId);
        return response()->json($phones);
    }

    /**
     *
     * @param UpdateClientPhone $request
     * @param integer $clientId
     * @param integer $id
     * @return JsonResponse
     */
    public function update(UpdateClientPhone $request, int $clientId, int $id): JsonResponse
    {
        $attributes = $request->all();
        $client = $this->clientService->updatePhone($clientId, $id, $attributes);
        return response()->json($client);
    }

    /**
     *
     * @param integer $clientId
     * @param integer $id
     * @return JsonResponse
     */
    public function destroy(int $clientId, int $id): JsonResponse
    {
        $client = $this->clientService->removePhone($clientId, $id);
        return response()->json($client);
    }
}
