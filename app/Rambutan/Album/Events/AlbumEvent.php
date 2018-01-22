<?php

namespace App\Rambutan\Album\Events;

use App\Rambutan\Album\AlbumId;
use Broadway\Serializer\Serializable;

abstract class AlbumEvent implements Serializable
{
    private $albumId;

    public function __construct(AlbumId $albumId)
    {
        $this->albumId = $albumId;
    }

    /**
     * @return \App\Rambutan\Album\AlbumId
     */
    public function getAlbumId()
    {
        return $this->albumId;
    }

    /**
     * {@inheritDoc}
     */
    public function serialize() : array
    {
        return ['albumId' => (string) $this->albumId];
    }
}
