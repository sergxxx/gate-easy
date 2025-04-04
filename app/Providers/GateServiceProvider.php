<?php

namespace App\Providers;

use App\Services\Gate\GateService;
use App\Services\Gate\GateServiceInterface;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Gate\GateRepository;
use App\Services\Gate\SendStrategies\ImmediateGateSendStrategy;
use App\Services\Gate\SendStrategies\QueuedGateSendStrategy;

class GateServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(GateServiceInterface::class, function ($app) {
            $sendStrategy = config('gate.send_queue')
                ? $app->make(QueuedGateSendStrategy::class)
                : $app->make(ImmediateGateSendStrategy::class);

            return new GateService(
                $app->make(GateRepository::class),
                $sendStrategy
            );
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
