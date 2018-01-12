<?php

/**
 * @date    2018-01-15
 * @file    PhotoWasDeleted.php
 * @author  Patrick Mac Gregor <macgregor.porta@gmail.com>
 */

namespace App\Rambutan\Photo\Events;

use App\Rambutan\Album\AlbumId;
use App\Rambutan\Photo\PhotoId;
use Carbon\Carbon;

class PhotoWasDeleted extends PhotoEvent
{
    private $deletedAt;
    private $albumId;

    public function __construct(
        PhotoId $photoId,
        Carbon $deletedAt,
        AlbumId $albumId = null
    ) {
        parent::__construct($photoId);

        $this->deletedAt = $deletedAt;
        $this->albumId = $albumId;
    }

    /**
     * {@inheritDoc}
     */
    public function serialize() : array
    {
        return array_merge(parent::serialize(), [
            'deletedAt' => $this->deletedAt->toAtomString()
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public static function deserialize(array $data)
    {
        return new self(
            new PhotoId($data['photoId']),
            new Carbon($data['deletedAt'])
        );
    }

    /**
     * @return mixed
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * @return mixed
     */
    public function getAlbumId()
    {
        return $this->albumId;
    }
}
