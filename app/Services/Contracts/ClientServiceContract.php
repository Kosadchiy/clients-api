<?php

namespace App\Services\Contracts;

use App\Client;
use Illuminate\Database\Eloquent\Collection;

interface ClientServiceContract
{
    public function all(): Collection;

    public function find(int $id): Client;

    public function store(array $attributes): Client;

    public function update(int $id, array $attributes): Client;

    public function destroy(int $id): void;

    public function clientPhones(int $clientId): Collection;

    public function updatePhone(int $clientId, int $id, array $attributes): Client;

    public function removePhone(int $clientId, int $id): Client;

    public function clientEmails(int $clientId): Collection;

    public function updateEmail(int $clientId, int $id, array $attributes): Client;

    public function removeEmail(int $clientId, int $id): Client;

    public function search(array $params): Collection;
}