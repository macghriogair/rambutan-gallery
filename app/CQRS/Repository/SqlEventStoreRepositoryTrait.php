<?php

/**
 * @date    2018-01-17
 * @file    SqlEventStoreRepositoryTrait.php
 * @author  Patrick Mac Gregor <macgregor.porta@gmail.com>
 */

namespace App\CQRS\Repository;

use Broadway\Domain\DomainEventStream;
use Broadway\EventStore\EventStore;
use Doctrine\DBAL\Driver\Connection;

trait SqlEventStoreRepositoryTrait
{
    /**
     * {@inheritDoc}
     */
    public function append($id, DomainEventStream $eventStream)
    {
        $this->eventStore()->append($id, $eventStream);
    }

    /**
     * {@inheritDoc}
     */
    public function getStreamIds()
    {
        $statement = $this->connection()->prepare('SELECT DISTINCT uuid FROM event_store');

        $statement->execute();

        return array_map(
            function ($row) {
                return $row['uuid'];
            },
            $statement->fetchAll()
        );
    }

    abstract protected function eventStore() : EventStore;
    abstract protected function connection() : Connection;
}
