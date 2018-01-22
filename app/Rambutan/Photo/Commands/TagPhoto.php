<?php

/**
 * @date    2018-01-15
 * @file    TagPhoto.php
 * @author  Patrick Mac Gregor <macgregor.porta@gmail.com>
 */

namespace App\Rambutan\Photo\Commands;

class TagPhoto extends PhotoCommand
{
    public function getTag()
    {
        return $this->payload()['tag'];
    }
}
