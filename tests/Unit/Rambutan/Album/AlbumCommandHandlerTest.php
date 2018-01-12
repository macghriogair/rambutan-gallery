<?php

namespace Tests\Rambutan;

use App\Rambutan\Album\AlbumCommandHandler;
use App\Rambutan\Album\AlbumId;
use App\Rambutan\Album\AlbumRepository;
use App\Rambutan\Album\Commands\AddAlbum;
use App\Rambutan\Album\Commands\DeleteAlbum;
use App\Rambutan\Album\Events\AlbumWasAdded;
use App\Rambutan\Album\Events\AlbumWasDeleted;
use Broadway\CommandHandling\CommandHandler;
use Broadway\CommandHandling\Testing\CommandHandlerScenarioTestCase;
use Broadway\EventHandling\EventBus;
use Broadway\EventStore\EventStore;
use Carbon\Carbon;

class AlbumCommandHandlerTest extends CommandHandlerScenarioTestCase
{
    /**
     * {@inheritDoc}
     */
    protected function createCommandHandler(EventStore $eventStore, EventBus $eventBus) : CommandHandler
    {
        $connectionMock = $this->getMockbuilder(\Doctrine\DBAL\Driver\Connection::class)->getMock();

        return new AlbumCommandHandler(
            new AlbumRepository($eventStore, $eventBus, $connectionMock)
        );
    }

    /** @test */
    public function testAddAlbum()
    {
        $albumId = new AlbumId('00000000-0000-0000-0000-000000000000');
        $this->scenario
            ->given([])
            ->when(new AddAlbum([
                'albumId' => $albumId,
                'name' => 'First Album',
                'description' => 'Lorem ipsum'
            ]))
            ->then([
                new AlbumWasAdded($albumId, 'First Album', 'Lorem ipsum')
            ]);
    }

    /** @test */
    public function testDeleteAlbum()
    {
        $albumId = new AlbumId('00000000-0000-0000-0000-000000000000');

        // create testing date
        $deletedAt = Carbon::create(2018, 3, 17, 01);
        Carbon::setTestNow($deletedAt);

        $this->scenario
            ->withAggregateId($albumId)
            ->given([
                new AlbumWasAdded($albumId, 'First Album', 'Lorem ipsum')
            ])
            ->when(new DeleteAlbum([
                'albumId' => $albumId
            ]))
            ->then([
                new AlbumWasDeleted($albumId, $deletedAt)
            ]);
    }
}
