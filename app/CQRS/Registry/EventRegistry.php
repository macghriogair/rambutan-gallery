<?php

namespace App\CQRS\Registry;

use Broadway\EventHandling\EventBus;

class EventRegistry extends AbstractRegistry
{
    /**
     * @var eventBus
     */
    private $eventBus;

    /**
     * @param eventBus $eventBus
     */
    public function __construct(EventBus $eventBus)
    {
        $this->eventBus = $eventBus;
    }

    /**
    * Subscribe the given array of projectors on the event bus
    *
    * @param  array $projectors
    */
    public function subscribe($projectors)
    {
        $projectors = $this->isTraversable($projectors) ? $projectors : [$projectors];
        foreach ($projectors as $projector) {
            $this->eventBus->subscribe($projector);
        }
    }

    /**
    * Check if the given argument is traversable
    *
    * @param $argument
    * @return bool
    */
    protected function isTraversable($argument)
    {
        return is_array($argument) || $argument instanceof \Traversable;
    }
}
