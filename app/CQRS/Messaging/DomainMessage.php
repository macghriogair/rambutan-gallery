<?php

declare(strict_types=1);

namespace App\CQRS\Messaging;

use Carbon\Carbon;

class DomainMessage
{
    private $id;

    private $name;

    private $event;

    private $dateTime;

    public function __construct($id, $event, Carbon $dateTime)
    {
        $this->id = $id;
        $this->event = $event;
        $this->name = end(explode('\\', get_class($event)));
        $this->dateTime = $dateTime;
    }

    public static function recordNow($id, $event)
    {
        return new static($id, $event, Carbon::now());
    }

    public function id()
    {
        return $this->id;
    }

    public function name()
    {
        return $this->name;
    }

    public function event()
    {
        return $this->event;
    }

    public function recordedOn()
    {
        return $this->dateTime;
    }
}
