<?php

namespace App\Infrastructure\Laravel\Providers;

use App\Domain\Auth\Repositories\AuthenticationServiceInterface;
use App\Domain\Auth\Repositories\UserRepositoryInterface;
use App\Domain\Common\Events\DomainEventDispatcher;
use App\Domain\Spy\Repositories\SpyRepositoryInterface;
use App\Infrastructure\Laravel\Events\LaravelEventDispatcher;
use App\Infrastructure\Laravel\Repositories\EloquentSpyRepository;
use App\Infrastructure\Laravel\Repositories\EloquentUserRepository;
use App\Infrastructure\Laravel\Services\SanctumAuthenticationService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Events\Dispatcher as LaravelDispatcher;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, EloquentUserRepository::class);
        $this->app->bind(AuthenticationServiceInterface::class, SanctumAuthenticationService::class);
        $this->app->bind(SpyRepositoryInterface::class, EloquentSpyRepository::class);

        $this->app->bind(DomainEventDispatcher::class, function ($app) {
            return new LaravelEventDispatcher($app->make(LaravelDispatcher::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
