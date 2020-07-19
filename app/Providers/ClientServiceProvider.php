<?php

namespace App\Providers;

use App\Services\ClientService;
use App\Services\Contracts\ClientServiceContract;
use Illuminate\Support\ServiceProvider;

class ClientServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            ClientServiceContract::class,
            ClientService::class
        );
    }
}
