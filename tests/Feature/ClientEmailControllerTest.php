<?php

namespace Tests\Feature;

use App\Client;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ClientEmailControllerTest extends TestCase
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

        $response = $this->get('/api/clients/'.$clientId.'/emails');
        $response->assertOk();
    }

    public function testUpdateClient()
    {
        $client = factory(Client::class)->create();
        Sanctum::actingAs(
            factory(User::class)->create()
        );

        $response = $this->put('/api/clients/'.$client->id.'/emails/'.$client->emails[0]->id, [
            'email' => 'test@test.ru'
        ]);
        $response->assertOk()
            ->assertSee('test@test.ru');
    }

    public function testDestroyClient()
    {
        $client = factory(Client::class)->create();
        Sanctum::actingAs(
            factory(User::class)->create()
        );
        $emailsCount = count($client->emails);
        $response = $this->delete('/api/clients/'.$client->id.'/emails/'.$client->emails[0]->id);
        $response->assertOk();
        $this->assertCount($emailsCount - 1, Client::find($client->id)->emails);
    }
}
