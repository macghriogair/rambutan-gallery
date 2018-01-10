<?php

namespace App\Traits;

trait AppliesRecordedEventsTrait
{
    public static function instantiateForReconstitution()
    {
        return new static();
    }

    public function applyRecordedEvents(array $events = [])
    {
        foreach ($events as $event) {
            $this->handle($event);
        }
    }
}
