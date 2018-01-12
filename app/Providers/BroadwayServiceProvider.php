<?php

namespace App\Providers;

use App\CQRS\Driver\Dbal;
use App\CQRS\Registry\CommandRegistry;
use App\CQRS\Registry\EventRegistry;
use App\Rambutan\Photo\Photo;
use App\Rambutan\Photo\PhotoRepository;
use Broadway\CommandHandling\SimpleCommandBus;
use Broadway\EventDispatcher\CallableEventDispatcher;
use Broadway\EventHandling\SimpleEventBus;
use Broadway\EventStore\Dbal\DBALEventStore;
use Broadway\Serializer\SimpleInterfaceSerializer;
use Broadway\UuidGenerator\Rfc4122\Version4Generator;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;
use Illuminate\Support\ServiceProvider;

class BroadwayServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // Eventing
        $this->app->singleton(\Broadway\EventDispatcher\EventDispatcher::class, function () {
            return new CallableEventDispatcher();
        });
        $this->app->singleton(\Broadway\EventHandling\EventBus::class, function () {
            return new SimpleEventBus();
        });

        // Command Bus
        $this->app->singleton(\Broadway\CommandHandling\CommandBus::class, function () {
            return new SimpleCommandBus();
        });

        // Serializer
        $this->app->bind(\Broadway\Serializer\Serializer::class, function () {
            return new SimpleInterfaceSerializer();
        });

        // Event Store
        $this->app->bind(\Broadway\EventStore\EventStore::class, function ($app) {
            return (new Dbal)->getDriver();
        });

        // UUID Generator
        $this->app->singleton(\Broadway\UuidGenerator\UuidGeneratorInterface::class, function() {
            return new Version4Generator();
        });

        $this->app->bind(\Doctrine\DBAL\Driver\Connection::class, \Doctrine\DBAL\Connection::class);


    }
}
