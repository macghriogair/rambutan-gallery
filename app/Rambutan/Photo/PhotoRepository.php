<?php

/**
 * @date    2018-01-12
 * @file    PhotoRepository.php
 * @author  Patrick Mac Gregor <macgregor.porta@gmail.com>
 */

namespace App\Rambutan\Photo;

use App\CQRS\Repository\SqlEventStoreRepositoryTrait;
use Broadway\EventHandling\EventBus;
use Broadway\EventSourcing\AggregateFactory\PublicConstructorAggregateFactory;
use Broadway\EventSourcing\EventSourcingRepository;
use Broadway\EventStore\EventStore;
use Doctrine\DBAL\Driver\Connection;

class PhotoRepository extends EventSourcingRepository
{
    use SqlEventStoreRepositoryTrait;

    private $eventStore;

    private $connection;

    public function __construct(
        EventStore $eventStore,
        EventBus $eventBus,
        Connection $connection
    ) {
        $this->eventStore = $eventStore;
        $this->connection = $connection;

        parent::__construct(
            $eventStore,
            $eventBus,
            Photo::class,
            new PublicConstructorAggregateFactory()
        );
    }

    protected function eventStore(): EventStore
    {
        return $this->eventStore;
    }

    protected function connection(): Connection
    {
        return $this->connection;
    }
}
