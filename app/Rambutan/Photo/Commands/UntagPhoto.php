<?php

/**
 * @date    2018-01-15
 * @file    UntagPhoto.php
 * @author  Patrick Mac Gregor <macgregor.porta@gmail.com>
 */

namespace App\Rambutan\Photo\Commands;

class UntagPhoto extends PhotoCommand
{
    public function getTag()
    {
        return $this->payload()['tag'];
    }
}
