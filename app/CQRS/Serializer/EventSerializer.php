<?php

declare(strict_types=1);

namespace App\CQRS\Serializer;

class EventSerializer
{
    public function serialize(SerializableEvent $event)
    {
        return [
            'type' => get_class($event),
            'payload' => $event->serialize()
        ];
    }

    public function deserialize($serializedEvent)
    {
        $eventClass = $serializedEvent->type;
        $eventPayload = $serializedEvent->payload;

        return $eventClass::deserialize($eventPayload);
    }
}
