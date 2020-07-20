<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateClientPhone;
use App\Services\Contracts\ClientServiceContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
        Log::info('API call.', [
            'user_id' => Auth::id(),
            'user_email' => Auth::user()->email,
            'client_id' => $clientId,
            'operation' => 'Get clients phones.'
        ]);
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
        Log::info('API call.', [
            'user_id' => Auth::id(),
            'user_email' => Auth::user()->email,
            'client_id' => $clientId,
            'phone_id' => $id,
            'operation' => 'Update clients phoen.'
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
        $client = $this->clientService->removePhone($clientId, $id);
        Log::info('API call.', [
            'user_id' => Auth::id(),
            'user_email' => Auth::user()->email,
            'client_id' => $clientId,
            'phone_id' => $id,
            'operation' => 'Delete clients phone.'
        ]);
        return response()->json($client);
    }
}
