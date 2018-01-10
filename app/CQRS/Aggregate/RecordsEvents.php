<?php

declare(strict_types=1);

namespace App\CQRS\Aggregate;

interface RecordsEvents
{
    public function getPendingEvents() : array;
}
