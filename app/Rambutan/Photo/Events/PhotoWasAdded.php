<?php

/**
 * @date    2018-01-15
 * @file    PhotoWasAdded.php
 * @author  Patrick Mac Gregor <macgregor.porta@gmail.com>
 */

namespace App\Rambutan\Photo\Events;

use App\Rambutan\Photo\PhotoId;

class PhotoWasAdded extends PhotoEvent
{
    private $name;
    private $description;

    public function __construct(
        PhotoId $photoId,
        string $name = null,
        string $description = null
    ) {
        parent::__construct($photoId);

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
            new PhotoId($data['photoId']),
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
