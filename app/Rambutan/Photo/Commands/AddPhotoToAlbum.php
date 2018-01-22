<?php

/**
 * @date    2018-01-15
 * @file    AddPhotoToAlbum.php
 * @author  Patrick Mac Gregor <macgregor.porta@gmail.com>
 */

namespace App\Rambutan\Photo\Commands;

class AddPhotoToAlbum extends PhotoCommand
{
    /**
     * @return mixed
     */
    public function getAlbumId()
    {
        return $this->payload()['albumId'];
    }
}
