<?php

declare(strict_types=1);

namespace App\Infrastructure\Laravel\Providers;

use App\Application\Agency\Commands\CreateAgencyCommand;
use App\Application\Agency\Handlers\AgencyQueryHandler;
use App\Application\Agency\Handlers\CreateAgencyHandler;
use App\Application\Agency\Handlers\ListAgenciesHandler;
use App\Application\Agency\Queries\AgencyQuery;
use App\Application\Agency\Queries\ListAgenciesQuery;
use App\Application\Auth\Commands\LoginCommand;
use App\Application\Auth\Commands\LogoutCommand;
use App\Application\Auth\Handlers\LoginHandler;
use App\Application\Auth\Handlers\LogoutHandler;
use App\Application\Spy\Commands\CreateSpyCommand;
use App\Application\Spy\Handlers\CreateSpyHandler;
use App\Application\Spy\Handlers\ListRandomSpiesHandler;
use App\Application\Spy\Handlers\ListSpiesHandler;
use App\Application\Spy\Queries\ListRandomSpiesQuery;
use App\Application\Spy\Queries\ListSpiesQuery;
use App\Domain\Agency\Repositories\AgencyRepositoryInterface;
use App\Domain\Auth\Contracts\AuthenticationServiceInterface;
use App\Domain\Auth\Repositories\UserRepositoryInterface;
use App\Domain\Common\Bus\CommandBus;
use App\Domain\Common\Bus\QueryBus;
use App\Domain\Common\Events\DomainEventDispatcher;
use App\Domain\Spy\Repositories\SpyRepositoryInterface;
use App\Infrastructure\Laravel\Bus\IlluminateCommandBus;
use App\Infrastructure\Laravel\Bus\IlluminateQueryBus;
use App\Infrastructure\Laravel\Events\IlluminateEventDispatcher;
use App\Infrastructure\Laravel\Repositories\EloquentAgencyRepository;
use App\Infrastructure\Laravel\Repositories\EloquentSpyRepository;
use App\Infrastructure\Laravel\Repositories\EloquentUserRepository;
use App\Infrastructure\Laravel\Services\SanctumAuthenticationService;
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
        $this->app->bind(AgencyRepositoryInterface::class, EloquentAgencyRepository::class);

        $this->app->bind(DomainEventDispatcher::class, IlluminateEventDispatcher::class);

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
            LoginCommand::class => LoginHandler::class,
            LogoutCommand::class => LogoutHandler::class,

            CreateSpyCommand::class => CreateSpyHandler::class,

            CreateAgencyCommand::class => CreateAgencyHandler::class,
        ]);

        $queryBus = app(QueryBus::class);

        $queryBus->register([
            ListRandomSpiesQuery::class => ListRandomSpiesHandler::class,
            ListSpiesQuery::class => ListSpiesHandler::class,

            ListAgenciesQuery::class => ListAgenciesHandler::class,
            AgencyQuery::class => AgencyQueryHandler::class,
        ]);
    }
}
