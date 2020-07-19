<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClient;
use App\Http\Requests\UpdateClient;
use App\Services\Contracts\ClientServiceContract;
use Illuminate\Http\JsonResponse;

class ClientController extends Controller
{
    private ClientServiceContract $clientService;

    public function __construct(ClientServiceContract $clientService)
    {
        $this->clientService = $clientService;
    }

    /**
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $clients = $this->clientService->all();
        return response()->json($clients);
    }

    /**
     *
     * @param StoreClient $request
     * @return JsonResponse
     */
    public function store(StoreClient $request): JsonResponse
    {
        $attributes = $request->all();
        $client = $this->clientService->store($attributes);
        return response()->json($client);
    }

    /**
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $client = $this->clientService->find($id);
        return response()->json($client);
    }

    /**
     *
     * @param UpdateClient $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateClient $request, int $id)
    {
        $attributes = $request->all();
        $client = $this->clientService->update($id, $attributes);
        return response()->json($client);
    }

    /**
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $this->clientService->destroy($id);
        return response()->json([
            'result' => true
        ]);
    }
}
