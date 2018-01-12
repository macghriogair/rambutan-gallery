<?php

/**
 * @date    2018-01-15
 * @file    ReadAlbumProjector.php
 * @author  Patrick Mac Gregor <macgregor.porta@gmail.com>
 */

namespace App\Rambutan\Album\ReadModel;

use App\Rambutan\Album\AlbumId;
use App\Rambutan\Album\Events\AlbumWasAdded;
use App\Rambutan\Album\Events\AlbumWasDeleted;
use App\Rambutan\Album\ReadModel\ReadAlbum;
use App\Rambutan\Photo\Events\PhotoWasAddedToAlbum;
use App\Rambutan\Photo\Events\PhotoWasDeleted;
use Broadway\ReadModel\Projector;

class ReadAlbumProjector extends Projector
{
    protected function applyAlbumWasAdded(AlbumWasAdded $event)
    {
        $album = new ReadAlbum();
        $album->uuid = (string) $event->getAlbumId();
        $album->name = $event->getName();
        $album->description = $event->getDescription();

        $album->save();
    }

    public function applyAlbumWasDeleted(AlbumWasDeleted $event)
    {
        $album = $this->getReadModel($event->getAlbumId());
        $album->delete();
    }

    public function applyPhotoWasAddedToAlbum(PhotoWasAddedToAlbum $event)
    {
        $album = $this->getReadModel($event->getAlbumId());
        $album->photo_count++;

        if ($oldAlbumId = $event->getOldAlbumId()) {
            $oldAlbum = $this->getReadModel($oldAlbumId);
            $oldAlbum->photo_count--;
            $oldAlbum->save();
        }

        $album->save();
    }

    public function applyPhotoWasDeleted(PhotoWasDeleted $event)
    {
        if (is_null($event->getAlbumId())) {
            return;
        }

        $album = $this->getReadModel($event->getAlbumId());
        $album->photo_count--;

        $album->save();
    }

    private function getReadModel(AlbumId $albumId)
    {
        $readModel = ReadAlbum::byUuid($albumId);

        if (null === $readModel) {
            $readModel = new ReadAlbum($albumId);
        }

        return $readModel;
    }
}
