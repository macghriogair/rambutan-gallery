<?php

/**
 * @date    2018-01-16
 * @file    PhotoEvent.php
 * @author  Patrick Mac Gregor <macgregor.porta@gmail.com>
 */

namespace App\Rambutan\Photo\Events;

use App\Rambutan\Photo\PhotoId;
use Broadway\Serializer\Serializable;

abstract class PhotoEvent implements Serializable
{
    private $photoId;

    public function __construct(PhotoId $photoId)
    {
        $this->photoId = $photoId;
    }

    /**
     * @return photoId
     */
    public function getPhotoId()
    {
        return $this->photoId;
    }

    /**
     * {@inheritDoc}
     */
    public function serialize() : array
    {
        return [
            'photoId' => (string) $this->photoId
        ];
    }
}
