<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchClient;
use App\Http\Requests\StoreClient;
use App\Http\Requests\UpdateClient;
use App\Services\Contracts\ClientServiceContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
        Log::info('API call.', [
            'user_id' => Auth::id(),
            'user_email' => Auth::user()->email,
            'operation' => 'Get all clients.'
        ]);
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
        Log::info('API call.', [
            'user_id' => Auth::id(),
            'user_email' => Auth::user()->email,
            'operation' => 'Store client.',
            'attributes' => $attributes
        ]);
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
        Log::info('API call.', [
            'user_id' => Auth::id(),
            'user_email' => Auth::user()->email,
            'operation' => 'Show client.'
        ]);
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
        Log::info('API call.', [
            'user_id' => Auth::id(),
            'user_email' => Auth::user()->email,
            'operation' => 'Update client.',
            'attributes' => $attributes
        ]);
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
        Log::info('API call.', [
            'user_id' => Auth::id(),
            'user_email' => Auth::user()->email,
            'operation' => 'Delete client.',
            'client_id' => $id
        ]);
        return response()->json([
            'result' => true
        ]);
    }

    /**
     *
     * @param SearchClient $request
     * @return void
     */
    public function search(SearchClient $request)
    {
        $params = $request->all();
        Log::info('API call.', [
            'user_id' => Auth::id(),
            'user_email' => Auth::user()->email,
            'operation' => 'Search client.',
            'params' => $params
        ]);
        return $this->clientService->search($params);
    }
}
