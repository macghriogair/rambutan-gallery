<?php

/**
 * @date    2018-01-15
 * @file    AlbumWasDeleted.php
 * @author  Patrick Mac Gregor <macgregor.porta@gmail.com>
 */

namespace App\Rambutan\Album\Events;

use App\Rambutan\Album\AlbumId;
use Carbon\Carbon;

class AlbumWasDeleted extends AlbumEvent
{
    private $deletedAt;

    public function __construct(
        AlbumId $albumId,
        Carbon $deletedAt
    ) {
        parent::__construct($albumId);

        $this->deletedAt = $deletedAt;
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
            new AlbumId($data['albumId']),
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
}
