<?php

/**
 * @date    2018-01-15
 * @file    PhotoWasDescribed.php
 * @author  Patrick Mac Gregor <macgregor.porta@gmail.com>
 */

namespace App\Rambutan\Photo\Events;

use App\Rambutan\Photo\PhotoId;

class PhotoWasDescribed extends PhotoEvent
{
    private $description;

    public function __construct(
        PhotoId $photoId,
        string $description
    ) {
        parent::__construct($photoId);

        $this->description = $description;
    }

    /**
     * {@inheritDoc}
     */
    public function serialize() : array
    {
        return array_merge(parent::serialize(), [
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
            $data['description']
        );
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }
}
