<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateClientEmail;
use App\Services\Contracts\ClientServiceContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
        Log::info('API call.', [
            'user_id' => Auth::id(),
            'user_email' => Auth::user()->email,
            'client_id' => $clientId,
            'operation' => 'Get clients emails.'
        ]);
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
        Log::info('API call.', [
            'user_id' => Auth::id(),
            'user_email' => Auth::user()->email,
            'client_id' => $clientId,
            'email_id' => $id,
            'operation' => 'Update clients email.'
        ]);
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
        Log::info('API call.', [
            'user_id' => Auth::id(),
            'user_email' => Auth::user()->email,
            'client_id' => $clientId,
            'email_id' => $id,
            'operation' => 'Delete clients email.'
        ]);
        return response()->json($client);
    }
}
