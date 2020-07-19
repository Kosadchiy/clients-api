<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateClientEmail;
use App\Services\Contracts\ClientServiceContract;
use Illuminate\Http\JsonResponse;

class ClientEmailController extends Controller
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
        $emails = $this->clientService->clientEmails($clientId);
        return response()->json($emails);
    }

    /**
     *
     * @param UpdateClientEmail $request
     * @param integer $clientId
     * @param integer $id
     * @return JsonResponse
     */
    public function update(UpdateClientEmail $request, int $clientId, int $id): JsonResponse
    {
        $attributes = $request->all();
        $client = $this->clientService->updateEmail($clientId, $id, $attributes);
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
        $client = $this->clientService->removeEmail($clientId, $id);
        return response()->json($client);
    }
}
