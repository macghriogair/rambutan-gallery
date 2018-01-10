<?php

declare(strict_types=1);

namespace App\CQRS\Aggregate;

use App\CQRS\Messaging\DomainMessage;

abstract class AggregateRoot implements RecordsEvents
{
    protected $pendingEvents = [];

    // Do not allow instantiation outside of factories
    protected function __construct()
    {
    }

    public function apply($event)
    {
        $this->handle($event);

        $this->pendingEvents[] = DomainMessage::recordNow(
            $this->aggregateId(),
            $event
        );
    }

    public function initializeState($events)
    {
        foreach ($events as $event) {
            $this->handle($event);
        }
    }

    public function getPendingEvents() : array
    {
        return $this->pendingEvents;
    }

    private function handle($event)
    {
        $method = $this->getApplyMethodName($event);

        if (! method_exists($this, $method)) {
            return;
        }

        $this->$method($event);
    }

    private function getApplyMethodName($event)
    {
        $className = get_class($event);

        $classParts = explode('\\', $className);
        $methodName = end($classParts);

        return 'apply'. $methodName;
    }

    abstract protected function aggregateId(): string;
}
