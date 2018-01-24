<?php

/**
 * @date    2018-01-15
 * @file    DescribePhoto.php
 * @author  Patrick Mac Gregor <macgregor.porta@gmail.com>
 */

namespace App\Rambutan\Photo\Commands;

class DescribePhoto extends PhotoCommand
{
    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->payload()['description'];
    }
}
