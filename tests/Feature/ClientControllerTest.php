<?php

namespace Tests\Feature;

use App\Client;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ClientControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Log::shouldReceive('info');
    }
    
    public function testGetAllClients()
    {
        for ($i = 0; $i < 3; $i++) { 
            factory(Client::class)->create();
        }

        Sanctum::actingAs(
            factory(User::class)->create()
        );

        $response = $this->get('/api/clients');
        $response->assertOk()->assertJsonCount(3);
    }

    public function testGetOneClient()
    {
        $clientId = factory(Client::class)->create()->id;
        Sanctum::actingAs(
            factory(User::class)->create()
        );

        $response = $this->get('/api/clients/'.$clientId);
        $response->assertOk()->assertJsonStructure(['name', 'surname', 'phones', 'emails']);
    }

    public function testStoreClient()
    {
        Sanctum::actingAs(
            factory(User::class)->create()
        );

        $response = $this->post('/api/clients', [
            'name' => 'John',
            'surname' => 'White',
            'phones' => [
                ['phone' => '542-32-33'],
                ['phone' => '544-32-33'],
            ],
            'emails' => [
                ['email' => 'test@test.ru'],
                ['email' => 'asd@qq.ru']
            ]
        ]);
        $response->assertOk()
            ->assertJsonPath('name', 'John')
            ->assertJsonPath('surname', 'White')
            ->assertJsonPath('phones.0.phone', '542-32-33')
            ->assertJsonPath('phones.1.phone', '544-32-33')
            ->assertJsonPath('emails.0.email', 'test@test.ru')
            ->assertJsonPath('emails.1.email', 'asd@qq.ru');
        $this->assertCount(1, Client::all());
    }

    public function testUpdateClient()
    {
        $clientId = factory(Client::class)->create()->id;
        Sanctum::actingAs(
            factory(User::class)->create()
        );

        $response = $this->put('/api/clients/'.$clientId, [
            'name' => 'John',
            'surname' => 'White',
            'phones' => [
                ['phone' => '542-32-33'],
                ['phone' => '544-32-33'],
            ],
            'emails' => [
                ['email' => 'test@test.ru'],
                ['email' => 'asd@qq.ru']
            ]
        ]);
        $response->assertOk()
            ->assertJsonPath('name', 'John')
            ->assertJsonPath('surname', 'White')
            ->assertSee('542-32-33')
            ->assertSee('544-32-33')
            ->assertSee('test@test.ru')
            ->assertSee('asd@qq.ru');
        $this->assertCount(1, Client::all());
    }

    public function testDestroyClient()
    {
        $clientId = factory(Client::class)->create()->id;
        Sanctum::actingAs(
            factory(User::class)->create()
        );

        $response = $this->delete('/api/clients/'.$clientId);
        $response->assertOk();
        $this->assertCount(0, Client::all());
    }

    public function testSearchClientByName()
    {
        Sanctum::actingAs(
            factory(User::class)->create()
        );

        $this->post('/api/clients', [
            'name' => 'John',
            'surname' => 'White',
            'phones' => [
                ['phone' => '542-32-33'],
                ['phone' => '544-32-33'],
            ],
            'emails' => [
                ['email' => 'test@test.ru'],
                ['email' => 'asd@qq.ru']
            ]
        ]);

        $response = $this->get('/api/clients/search?search_type=name&query_string=joh');
        $response->assertOk()->assertJsonCount(1);

        $response = $this->get('/api/clients/search?search_type=name&query_string=hite');
        $response->assertOk()->assertJsonCount(1);

        $response = $this->get('/api/clients/search?search_type=name&query_string=asdd');
        $response->assertOk()->assertJsonCount(0);
    }

    public function testSearchClientByPhone()
    {
        Sanctum::actingAs(
            factory(User::class)->create()
        );

        $this->post('/api/clients', [
            'name' => 'John',
            'surname' => 'White',
            'phones' => [
                ['phone' => '542-32-33'],
                ['phone' => '544-32-33'],
            ],
            'emails' => [
                ['email' => 'test@test.ru'],
                ['email' => 'asd@qq.ru']
            ]
        ]);

        $response = $this->get('/api/clients/search?search_type=phone&query_string=542');
        $response->assertOk()->assertJsonCount(1);

        $response = $this->get('/api/clients/search?search_type=phone&query_string=544');
        $response->assertOk()->assertJsonCount(1);

        $response = $this->get('/api/clients/search?search_type=phone&query_string=111');
        $response->assertOk()->assertJsonCount(0);
    }

    public function testSearchClientByEmail()
    {
        Sanctum::actingAs(
            factory(User::class)->create()
        );

        $this->post('/api/clients', [
            'name' => 'John',
            'surname' => 'White',
            'phones' => [
                ['phone' => '542-32-33'],
                ['phone' => '544-32-33'],
            ],
            'emails' => [
                ['email' => 'test@test.ru'],
                ['email' => 'asd@qq.ru']
            ]
        ]);

        $response = $this->get('/api/clients/search?search_type=email&query_string=test');
        $response->assertOk()->assertJsonCount(1);

        $response = $this->get('/api/clients/search?search_type=email&query_string=sd@q');
        $response->assertOk()->assertJsonCount(1);

        $response = $this->get('/api/clients/search?search_type=email&query_string=yandex');
        $response->assertOk()->assertJsonCount(0);
    }

    public function testSearchClientByAll()
    {
        Sanctum::actingAs(
            factory(User::class)->create()
        );

        $this->post('/api/clients', [
            'name' => 'John',
            'surname' => 'White',
            'phones' => [
                ['phone' => '542-32-33'],
                ['phone' => '544-32-33'],
            ],
            'emails' => [
                ['email' => 'test@test.ru'],
                ['email' => 'asd@qq.ru']
            ]
        ]);

        $response = $this->get('/api/clients/search?search_type=all&query_string=john');
        $response->assertOk()->assertJsonCount(1);

        $response = $this->get('/api/clients/search?search_type=all&query_string=hite');
        $response->assertOk()->assertJsonCount(1);

        $response = $this->get('/api/clients/search?search_type=all&query_string=-32');
        $response->assertOk()->assertJsonCount(1);

        $response = $this->get('/api/clients/search?search_type=all&query_string=544');
        $response->assertOk()->assertJsonCount(1);
        
        $response = $this->get('/api/clients/search?search_type=all&query_string=test');
        $response->assertOk()->assertJsonCount(1);

        $response = $this->get('/api/clients/search?search_type=all&query_string=asd');
        $response->assertOk()->assertJsonCount(1);

        $response = $this->get('/api/clients/search?search_type=all&query_string=asasddwdqd');
        $response->assertOk()->assertJsonCount(0);
    }
}
