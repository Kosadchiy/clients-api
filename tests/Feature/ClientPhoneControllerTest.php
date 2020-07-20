<?php

namespace Tests\Feature;

use App\Client;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ClientPhoneControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Log::shouldReceive('info');
    }
    
    public function testGetAllClientsPhoens()
    {
        $clientId = factory(Client::class)->create()->id;

        Sanctum::actingAs(
            factory(User::class)->create()
        );

        $response = $this->get('/api/clients/'.$clientId.'/phones');
        $response->assertOk();
    }

    public function testUpdateClient()
    {
        $client = factory(Client::class)->create();
        Sanctum::actingAs(
            factory(User::class)->create()
        );

        $response = $this->put('/api/clients/'.$client->id.'/phones/'.$client->phones[0]->id, [
            'phone' => '542-32-33'
        ]);
        $response->assertOk()
            ->assertSee('542-32-33');
    }

    public function testDestroyClient()
    {
        $client = factory(Client::class)->create();
        Sanctum::actingAs(
            factory(User::class)->create()
        );
        $phonesCount = count($client->phones);
        $response = $this->delete('/api/clients/'.$client->id.'/phones/'.$client->phones[0]->id);
        $response->assertOk();
        $this->assertCount($phonesCount - 1, Client::find($client->id)->phones);
    }
}
