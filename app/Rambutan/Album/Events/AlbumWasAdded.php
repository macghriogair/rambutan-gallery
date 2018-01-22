<?php

/**
 * @date    2018-01-15
 * @file    AlbumWasAdded.php
 * @author  Patrick Mac Gregor <macgregor.porta@gmail.com>
 */

namespace App\Rambutan\Album\Events;

use App\Rambutan\Album\AlbumId;

class AlbumWasAdded extends AlbumEvent
{
    private $name;
    private $description;

    public function __construct(
        AlbumId $albumId,
        string $name = null,
        string $description = null
    ) {
        parent::__construct($albumId);

        $this->name = $name;
        $this->description = $description;
    }

    /**
     * {@inheritDoc}
     */
    public function serialize() : array
    {
        return array_merge(parent::serialize(), [
            'name' => $this->name,
            'description' => $this->description
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public static function deserialize(array $data)
    {
        return new self(
            new AlbumId($data['albumId']),
            $data['name'],
            $data['description']
        );
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }
}
