<?php

namespace App\Infrastructure\Laravel\Providers;

use App\Application\Auth\Commands\LoginCommand;
use App\Application\Auth\Commands\LoginHandler;
use App\Application\Auth\Commands\LogoutCommand;
use App\Application\Auth\Commands\LogoutHandler;
use App\Application\Spy\Commands\CreateSpyCommand;
use App\Application\Spy\Commands\CreateSpyHandler;
use App\Application\Spy\Queries\ListRandomSpiesHandler;
use App\Application\Spy\Queries\ListRandomSpiesQuery;
use App\Domain\Auth\Repositories\AuthenticationServiceInterface;
use App\Domain\Auth\Repositories\UserRepositoryInterface;
use App\Domain\Common\Bus\CommandBus;
use App\Domain\Common\Bus\QueryBus;
use App\Domain\Common\Events\DomainEventDispatcher;
use App\Domain\Spy\Repositories\SpyRepositoryInterface;
use App\Infrastructure\Laravel\Bus\IlluminateCommandBus;
use App\Infrastructure\Laravel\Bus\IlluminateQueryBus;
use App\Infrastructure\Laravel\Events\LaravelEventDispatcher;
use App\Infrastructure\Laravel\Repositories\EloquentSpyRepository;
use App\Infrastructure\Laravel\Repositories\EloquentUserRepository;
use App\Infrastructure\Laravel\Services\SanctumAuthenticationService;
use Illuminate\Contracts\Events\Dispatcher as LaravelDispatcher;
use Illuminate\Support\ServiceProvider;

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

        $this->app->singleton(CommandBus::class, IlluminateCommandBus::class);
        $this->app->singleton(QueryBus::class, IlluminateQueryBus::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $commandBus = app(CommandBus::class);

        $commandBus->register([
            LoginCommand::class     => LoginHandler::class,
            LogoutCommand::class    => LogoutHandler::class,
            CreateSpyCommand::class => CreateSpyHandler::class,
        ]);

        $queryBus = app(QueryBus::class);

        $queryBus->register([
            ListRandomSpiesQuery::class => ListRandomSpiesHandler::class,
        ]);
    }
}
