<?php

namespace App\Model\Photo;

use App\CQRS\Aggregate\AggregateRoot;
use App\CQRS\Aggregate\RecordsEvents;

class Photo extends AggregateRoot
{

    protected function aggregateId()
    {
        return $this->id;
    }


}
