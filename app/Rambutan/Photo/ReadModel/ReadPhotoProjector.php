<?php

/**
 * @date    2018-01-15
 * @file    ReadPhotoProjector.php
 * @author  Patrick Mac Gregor <macgregor.porta@gmail.com>
 */

namespace App\Rambutan\Photo\ReadModel;

use App\Rambutan\Photo\Events\PhotoWasAdded;
use App\Rambutan\Photo\Events\PhotoWasAddedToAlbum;
use App\Rambutan\Photo\Events\PhotoWasDescribed;
use App\Rambutan\Photo\Events\PhotoWasTagged;
use App\Rambutan\Photo\Events\PhotoWasUntagged;
use App\Rambutan\Photo\PhotoId;
use Broadway\ReadModel\Projector;

class ReadPhotoProjector extends Projector
{
    protected function applyPhotoWasAdded(PhotoWasAdded $event)
    {
        $photo = new ReadPhoto();
        if ($event->getAlbumId()) {
            $photo->album_id = $event->getAlbumId();
        }
        $photo->uuid = (string) $event->getPhotoId();
        $photo->name = $event->getName();
        $photo->description = $event->getDescription();
        $photo->url = '';
        $photo->thumb_url = '';
        $photo->type = 'jpeg';
        $photo->save();
    }

    protected function applyPhotoWasTagged(PhotoWasTagged $event)
    {
        $photo = $this->getReadModel($event->getPhotoId());

        $newTags = [$event->getTag()];
        $currentTags = $photo->tags ?: [];
        $photo->tags = array_unique(array_merge($currentTags, $newTags));

        $photo->save();
    }

    protected function applyPhotoWasUntagged(PhotoWasUntagged $event)
    {
        $photo = $this->getReadModel($event->getPhotoId());
        $tags = array_filter($photo->tags, function ($tag) use ($event) {
            return $tag !== $event->getTag();
        });
        $photo->tags = array_values($tags);

        $photo->save();
    }

    protected function applyPhotoWasDescribed(PhotoWasDescribed $event)
    {
        $photo = $this->getReadModel($event->getPhotoId());
        $photo->description = $event->getDescription();

        $photo->save();
    }

    protected function applyPhotoWasDeleted(PhotoWasDeleted $event)
    {
        $photo = $this->getReadModel($event->getPhotoId());
        $photo->delete();
    }

    protected function applyPhotoWasAddedToAlbum(PhotoWasAddedToAlbum $event)
    {
        $photo = $this->getReadModel($event->getPhotoId());
        $photo->album_id = (string) $event->getAlbumId();

        $photo->save();
    }

    private function getReadModel(PhotoId $photoId)
    {
        $readModel = ReadPhoto::byUuid($photoId);

        if (null === $readModel) {
            $readModel = new ReadPhoto($photoId);
        }

        return $readModel;
    }
}
