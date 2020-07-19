<?php

namespace App\Services;

use App\Client;
use App\Services\Contracts\ClientServiceContract;
use Illuminate\Database\Eloquent\Collection;

class ClientService implements ClientServiceContract
{
    public function all(): Collection
    {
        return Client::all();
    }

    public function find(int $id): Client
    {
        return Client::findOrFail($id);
    }

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

    public function search(array $params): Collection
    {
        return Client::all();
    }

    public function clientPhones(int $clientId): Collection
    {
        return $this->find($clientId)->phones;
    }

    public function updatePhone(int $clientId, int $id, array $attributes): Client
    {
        $phone = $this->find($clientId)->phones()->where('id', $id)->firstOrFail();
        $phone->update($attributes);
        return $phone->client;
    }

    public function removePhone(int $clientId, int $id): Client
    {
        $this->find($clientId)->phones()->where('id', $id)->firstOrFail()->delete();
        return $this->find($clientId);
    }

    public function clientEmails(int $clientId): Collection
    {
        return $this->find($clientId)->emails;
    }

    public function updateEmail(int $clientId, int $id, array $attributes): Client
    {
        $email = $this->find($clientId)->emails()->where('id', $id)->firstOrFail();
        $email->update($attributes);
        return $email->client;
    }

    public function removeEmail(int $clientId, int $id): Client
    {
        $this->find($clientId)->emails()->where('id', $id)->firstOrFail()->delete();
        return $this->find($clientId);
    }
}