<?php

namespace App\Providers;

use App\Services\Gate\GateService;
use App\Services\Gate\GateServiceInterface;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Gate\GateRepository;
use App\Repositories\Gate\GateRepositoryInterface;

class GateServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(GateServiceInterface::class, GateService::class);
        $this->app->bind(GateRepositoryInterface::class, GateRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
