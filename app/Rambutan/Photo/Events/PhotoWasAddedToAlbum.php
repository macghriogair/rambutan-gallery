<?php

/**
 * @date    2018-01-15
 * @file    PhotoWasAddedToAlbum.php
 * @author  Patrick Mac Gregor <macgregor.porta@gmail.com>
 */

namespace App\Rambutan\Photo\Events;

use App\Rambutan\Album\AlbumId;
use App\Rambutan\Photo\PhotoId;

class PhotoWasAddedToAlbum extends PhotoEvent
{
    private $albumId;
    private $oldAlbumId;

    public function __construct(
        PhotoId $photoId,
        AlbumId $albumId,
        AlbumId $oldAlbumId = null
    ) {
        parent::__construct($photoId);

        $this->albumId = $albumId;
        $this->oldAlbumId = $oldAlbumId;
    }

    /**
     * {@inheritDoc}
     */
    public function serialize() : array
    {
        return array_merge(parent::serialize(), [
            'albumId' => (string) $this->albumId,
            'oldAlbumId' => is_null($this->oldAlbumId) ? null : (string) $this->oldAlbumId
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public static function deserialize(array $data)
    {
        return new self(
            new PhotoId($data['photoId']),
            new AlbumId($data['albumId']),
            is_null($data['oldAlbumId']) ? null : new AlbumId($data['oldAlbumId'])
        );
    }

    /**
     * @return mixed
     */
    public function getAlbumId()
    {
        return $this->albumId;
    }

    /**
     * @return mixed
     */
    public function getOldAlbumId()
    {
        return $this->oldAlbumId;
    }
}
