<?php

namespace Tests\Rambutan;

use App\Rambutan\Album\AlbumId;
use App\Rambutan\Album\Events\AlbumWasAdded;
use App\Rambutan\Photo\Commands as Commands;
use App\Rambutan\Photo\Events as Events;
use App\Rambutan\Photo\PhotoCommandHandler;
use App\Rambutan\Photo\PhotoId;
use App\Rambutan\Photo\PhotoRepository;
use Broadway\CommandHandling\CommandHandler;
use Broadway\CommandHandling\Testing\CommandHandlerScenarioTestCase;
use Broadway\EventHandling\EventBus;
use Broadway\EventStore\EventStore;
use Carbon\Carbon;

class PhotoCommandHandlerTest extends CommandHandlerScenarioTestCase
{
    /**
     * {@inheritDoc}
     */
    protected function createCommandHandler(EventStore $eventStore, EventBus $eventBus) : CommandHandler
    {
        $connectionMock = $this->getMockbuilder(\Doctrine\DBAL\Driver\Connection::class)->getMock();

        return new PhotoCommandHandler(
            new PhotoRepository($eventStore, $eventBus, $connectionMock)
        );
    }

    /** @test */
    public function testAddPhoto()
    {
        $photoId = new PhotoId('00000000-0000-0000-0000-000000000000');
        $this->scenario
            ->given([])
            ->when(new Commands\AddPhoto([
                'photoId' => $photoId,
                'name' => 'First Photo',
                'description' => 'Lorem ipsum'
            ]))
            ->then([
                new Events\PhotoWasAdded($photoId, 'First Photo', 'Lorem ipsum')
            ]);
    }

    /** @test */
    public function testTagPhoto()
    {
        $photoId = new PhotoId('00000000-0000-0000-0000-000000000000');
        $this->scenario
            ->withAggregateId($photoId)
            ->given([
                new Events\PhotoWasAdded($photoId, 'First Photo', 'Lorem ipsum')
            ])
            ->when(new Commands\TagPhoto(['photoId' => $photoId, 'tag' => 'Berlin']))
            ->then([
                new Events\PhotoWasTagged($photoId, 'Berlin')
            ]);
    }

    /** @test */
    public function testUntagPhoto()
    {
        $photoId = new PhotoId('00000000-0000-0000-0000-000000000000');
        $this->scenario
            ->withAggregateId($photoId)
            ->given([
                new Events\PhotoWasAdded($photoId, 'First Photo', 'Lorem ipsum'),
                new Events\PhotoWasTagged($photoId, 'Berlin')
            ])
            ->when(new Commands\UntagPhoto(['photoId' => $photoId, 'tag' => 'Berlin']))
            ->then([
                new Events\PhotoWasUntagged($photoId, 'Berlin')
            ]);
    }

    /** @test */
    public function testDeletePhoto()
    {
        $photoId = new PhotoId('00000000-0000-0000-0000-000000000000');

        // create testing date
        $deletedAt = Carbon::create(2018, 3, 17, 01);
        Carbon::setTestNow($deletedAt);

        $this->scenario
            ->withAggregateId($photoId)
            ->given([
                new Events\PhotoWasAdded($photoId, 'First Photo', 'Lorem ipsum')
            ])
            ->when(new Commands\DeletePhoto(['photoId' => $photoId]))
            ->then([
                new Events\PhotoWasDeleted($photoId, $deletedAt)
            ]);
    }

    /** @test */
    public function testAddPhotoToAlbum()
    {
        $photoId = new PhotoId('00000000-0000-0000-0000-000000000000');
        $albumId = new AlbumId('00000000-0000-0000-0000-000000000001');

        $this->scenario
            ->withAggregateId($photoId)
            ->given([
                new Events\PhotoWasAdded($photoId, 'First Photo', 'Lorem ipsum'),
                new AlbumWasAdded($albumId, 'First Album', 'Lorem ipsum')
            ])
            ->when(new Commands\AddPhotoToAlbum([
                'photoId' => $photoId,
                'albumId' => $albumId
            ]))
            ->then([
                new Events\PhotoWasAddedToAlbum($photoId, $albumId)
            ]);
    }
}
