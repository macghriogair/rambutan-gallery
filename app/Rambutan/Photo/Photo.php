<?php

/**
 * @date    2018-01-12
 * @file    Photo.php
 * @author  Patrick Mac Gregor <macgregor.porta@gmail.com>
 */

namespace App\Rambutan\Photo;

use App\Rambutan\Album\AlbumId;
use App\Rambutan\Photo\Events\PhotoWasAdded;
use App\Rambutan\Photo\Events\PhotoWasAddedToAlbum;
use App\Rambutan\Photo\Events\PhotoWasDeleted;
use App\Rambutan\Photo\Events\PhotoWasTagged;
use App\Rambutan\Photo\Events\PhotoWasUntagged;
use Broadway\EventSourcing\EventSourcedAggregateRoot;
use Carbon\Carbon;
use Broadway\EventSourcing\SimpleEventSourcedEntity;

class Photo extends EventSourcedAggregateRoot
{
    private $id;
    private $name;
    private $description;
    private $tags = [];
    private $albumId;
    private $metadata;
    private $deletedAt;

    public function getAggregateRootId() : string
    {
        return $this->id;
    }

    public static function addPhoto(PhotoId $photoId, $name, $description)
    {
        $photo = new self();
        $photo->apply(new PhotoWasAdded($photoId, $name, $description));

        return $photo;
    }

    protected function applyPhotoWasAdded(PhotoWasAdded $event)
    {
        $this->id = $event->getPhotoId();
        $this->name = $event->getName();
        $this->description = $event->getDescription();
        $this->metadata = new ImageMetadata(); // TODO
    }

    public function addTag(string $tag)
    {
        if (isset($this->tags[$tag])) {
            return;
        }

        $this->apply(
            new PhotoWasTagged($this->id, $tag)
        );
    }

    public function applyPhotoWasTagged(PhotoWasTagged $event)
    {
        $this->tags[$event->getTag()] = true;
    }

    public function removeTag(string $tag)
    {
        if (! isset($this->tags[$tag])) {
            return;
        }

        $this->apply(
            new PhotoWasUntagged($this->id, $tag)
        );
    }

    public function applyPhotoWasUntagged(PhotoWasUntagged $event)
    {
        unset($this->tags[$event->getTag()]);
    }

    public function delete()
    {
        if (! is_null($this->deletedAt)) {
            return;
        }

        $this->apply(
            new PhotoWasDeleted($this->id, Carbon::now(), $this->albumId)
        );
    }

    public function applyPhotoWasDeleted(PhotoWasDeleted $event)
    {
        $this->deletedAt = $event->getDeletedAt();
    }

    public function addToAlbum(AlbumId $albumId)
    {
        $this->apply(
            new PhotoWasAddedToAlbum($this->id, $albumId, $this->albumId)
        );
    }

    protected function applyPhotoWasAddedToAlbum(PhotoWasAddedToAlbum $event)
    {
        $this->albumId = $event->getAlbumId();
    }

    protected function getChildEntities() : array
    {
        return [$this->metadata];
    }
}
