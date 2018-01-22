<?php

/**
 * @date    2018-01-15
 * @file    PhotoCommand.php
 * @author  Patrick Mac Gregor <macgregor.porta@gmail.com>
 */

namespace App\Rambutan\Photo\Commands;

use App\CQRS\Messaging\PayloadTrait;

abstract class PhotoCommand
{
    use PayloadTrait;

    /**
     * @return \App\Rambutan\Photo\PhotoId
     */
    public function getPhotoId()
    {
        return $this->payload()['photoId'];
    }
}
