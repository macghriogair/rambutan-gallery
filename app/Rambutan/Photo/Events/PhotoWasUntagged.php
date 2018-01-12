<?php

/**
 * @date    2018-01-15
 * @file    PhotoWasUntagged.php
 * @author  Patrick Mac Gregor <macgregor.porta@gmail.com>
 */

namespace App\Rambutan\Photo\Events;

use App\Rambutan\Photo\PhotoId;

class PhotoWasUntagged extends PhotoEvent
{
    private $tag;

    public function __construct(
        PhotoId $photoId,
        string $tag
    ) {
        parent::__construct($photoId);

        $this->tag = $tag;
    }

    /**
     * @return string
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * {@inheritDoc}
     */
    public function serialize() : array
    {
        return array_merge(parent::serialize(), [
            'tag' => $this->tag,
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public static function deserialize(array $data)
    {
        return new self(
            new PhotoId($data['photoId']),
            $data['tag']
        );
    }
}
