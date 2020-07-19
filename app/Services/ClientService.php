<?php

namespace App\Services;

use App\Client;
use App\Services\Contracts\ClientServiceContract;
use Illuminate\Database\Eloquent\Collection;

class ClientService implements ClientServiceContract
{
    /**
     *
     * @return Collection|Client[]
     */
    public function all(): Collection
    {
        return Client::all();
    }

    /**
     *
     * @param integer $id
     * @return Client
     */
    public function find(int $id): Client
    {
        return Client::findOrFail($id);
    }

    /**
     *
     * @param array $attributes
     * @return Client
     */
    public function store(array $attributes): Client
    {
        $client = Client::create($attributes);
        if (isset($attributes['phones'])) {
            $client->phones()->createMany($attributes['phones']);
        }
        if (isset($attributes['emails'])) {
            $client->emails()->createMany($attributes['emails']);
        }
        return $this->find($client->id);
    }

    /**
     *
     * @param integer $id
     * @param array $attributes
     * @return Client
     */
    public function update(int $id, array $attributes): Client
    {
        $client = $this->find($id);
        $client->fill($attributes);
        $client->save();
        if (isset($attributes['phones'])) {
            $client->phones()->createMany($attributes['phones']);
        }
        if (isset($attributes['emails'])) {
            $client->emails()->createMany($attributes['emails']);
        }
        return $this->find($client->id);
    }

    public function destroy(int $id): void
    {
        $this->find($id)->delete();
    }

    /**
     *
     * @param array $params
     * @return Collection|Client[]
     */
    public function search(array $params): Collection
    {
        switch ($params['search_type']) {
            case 'all':
                return $this->searchByAll($params['query_string']);
            case 'name':
                return $this->searchByName($params['query_string']);
            case 'phone':
                return $this->searchByPhone($params['query_string']);
            case 'email':
                return $this->searchByEmail($params['query_string']);
            
            default:
                throw new \Exception("Undefined search type");
        }
        return Client::all();
    }

    /**
     *
     * @param integer $clientId
     * @return Collection|App\ClientPhone[]
     */
    public function clientPhones(int $clientId): Collection
    {
        return $this->find($clientId)->phones;
    }

    /**
     *
     * @param integer $clientId
     * @param integer $id
     * @param array $attributes
     * @return Client
     */
    public function updatePhone(int $clientId, int $id, array $attributes): Client
    {
        $phone = $this->find($clientId)->phones()->where('id', $id)->firstOrFail();
        $phone->update($attributes);
        return $phone->client;
    }

    /**
     *
     * @param integer $clientId
     * @param integer $id
     * @return Client
     */
    public function removePhone(int $clientId, int $id): Client
    {
        $this->find($clientId)->phones()->where('id', $id)->firstOrFail()->delete();
        return $this->find($clientId);
    }

    /**
     *
     * @param integer $clientId
     * @return Collection|App\ClientEmail[]
     */
    public function clientEmails(int $clientId): Collection
    {
        return $this->find($clientId)->emails;
    }

    /**
     *
     * @param integer $clientId
     * @param integer $id
     * @param array $attributes
     * @return Client
     */
    public function updateEmail(int $clientId, int $id, array $attributes): Client
    {
        $email = $this->find($clientId)->emails()->where('id', $id)->firstOrFail();
        $email->update($attributes);
        return $email->client;
    }

    /**
     *
     * @param integer $clientId
     * @param integer $id
     * @return Client
     */
    public function removeEmail(int $clientId, int $id): Client
    {
        $this->find($clientId)->emails()->where('id', $id)->firstOrFail()->delete();
        return $this->find($clientId);
    }

    /**
     *
     * @param string $queryString
     * @return Collection|Client[]
     */
    private function searchByAll(string $queryString): Collection
    {
        return Client::where('name', 'like', "%$queryString%")
            ->orWhere('surname', 'like', "%$queryString%")
            ->orWhereHas('phones', function ($query) use ($queryString) {
                $query->where('phone', 'like', "%$queryString%");
            })->orWhereHas('emails', function ($query) use ($queryString) {
                $query->where('email', 'like', "%$queryString%");
            })->get();
    }

    /**
     *
     * @param string $queryString
     * @return Collection|Client[]
     */
    private function searchByName(string $queryString): Collection
    {
        return Client::where('name', 'like', "%$queryString%")
            ->orWhere('surname', 'like', "%$queryString%")->get();
    }

    /**
     *
     * @param string $queryString
     * @return Collection|Client[]
     */
    private function searchByPhone(string $queryString): Collection
    {
        return Client::whereHas('phones', function ($query) use ($queryString) {
            $query->where('phone', 'like', "%$queryString%");
        })->get();
    }

    /**
     *
     * @param string $queryString
     * @return Collection|Client[]
     */
    private function searchByEmail(string $queryString): Collection
    {
        return Client::whereHas('emails', function ($query) use ($queryString) {
            $query->where('email', 'like', "%$queryString%");
        })->get();
    }
}