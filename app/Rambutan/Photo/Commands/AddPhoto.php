<?php

/**
 * @date    2018-01-15
 * @file    AddPhoto.php
 * @author  Patrick Mac Gregor <macgregor.porta@gmail.com>
 */

namespace App\Rambutan\Photo\Commands;

class AddPhoto extends PhotoCommand
{
    public function getAlbumId()
    {
        return $this->payload()['albumId'];
    }

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->payload()['file'];
    }

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
