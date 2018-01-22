<?php

/**
 * @date    2018-01-15
 * @file    AlbumCommand.php
 * @author  Patrick Mac Gregor <macgregor.porta@gmail.com>
 */

namespace App\Rambutan\Album\Commands;

use App\CQRS\Messaging\PayloadTrait;

abstract class AlbumCommand
{
    use PayloadTrait;

    /**
     * @return \App\Rambutan\Album\AlbumId
     */
    public function getAlbumId()
    {
        return $this->payload()['albumId'];
    }
}
