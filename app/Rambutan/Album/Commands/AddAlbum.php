<?php

/**
 * @date    2018-01-15
 * @file    AddAlbum.php
 * @author  Patrick Mac Gregor <macgregor.porta@gmail.com>
 */

namespace App\Rambutan\Album\Commands;

class AddAlbum extends AlbumCommand
{
    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->payload()['name'];
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->payload()['description'];
    }
}
