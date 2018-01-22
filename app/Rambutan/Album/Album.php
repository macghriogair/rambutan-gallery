<?php

/**
 * @date    2018-01-12
 * @file    Album.php
 * @author  Patrick Mac Gregor <macgregor.porta@gmail.com>
 */

namespace App\Rambutan\Album;

use App\Rambutan\Album\Events\AlbumWasAdded;
use App\Rambutan\Album\Events\AlbumWasDeleted;
use Broadway\EventSourcing\EventSourcedAggregateRoot;
use Carbon\Carbon;

class Album extends EventSourcedAggregateRoot
{
    private $id;
    private $name;
    private $description;
    private $deletedAt;

    public function getAggregateRootId() : string
    {
        return $this->id;
    }

    public static function addAlbum(AlbumId $albumId, $name, $description)
    {
        $album = new self();
        $album->apply(new AlbumWasAdded($albumId, $name, $description));

        return $album;
    }

    protected function applyAlbumWasAdded(AlbumWasAdded $event)
    {
        $this->id = $event->getAlbumId();
        $this->name = $event->getName();
        $this->description = $event->getDescription();
    }

    public function delete()
    {
        if (! is_null($this->deletedAt)) {
            return;
        }

        $this->apply(
            new AlbumWasDeleted($this->id, Carbon::now())
        );
    }

    public function applyAlbumWasDeleted(AlbumWasDeleted $event)
    {
        $this->deletedAt = $event->getDeletedAt();
    }
}
