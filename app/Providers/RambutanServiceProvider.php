<?php

namespace App\Providers;

use App\CQRS\Registry\CommandRegistry;
use App\CQRS\Registry\EventRegistry;
use Illuminate\Support\ServiceProvider;

class RambutanServiceProvider extends ServiceProvider
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
        // Command Handlers
        $this->app->singleton('broadway.command.registry', CommandRegistry::class);
        $this->app['broadway.command.registry']->subscribe([
            new \App\Rambutan\Photo\PhotoCommandHandler(
                $this->app[\App\Rambutan\Photo\PhotoRepository::class]
            ),
            new \App\Rambutan\Album\AlbumCommandHandler(
                $this->app[\App\Rambutan\Album\AlbumRepository::class]
            )
        ]);

        // Subscribe Projectors to Events
        $this->app->singleton('broadway.event.registry', EventRegistry::class);
        $this->app['broadway.event.registry']->subscribe([
            new \App\Rambutan\Photo\ReadModel\ReadPhotoProjector(),
            new \App\Rambutan\Album\ReadModel\ReadAlbumProjector()
        ]);
    }
}
