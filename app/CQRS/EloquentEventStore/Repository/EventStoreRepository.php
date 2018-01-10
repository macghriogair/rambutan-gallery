<?php

declare(strict_types=1);

namespace App\CQRS\EloquentEventStore\Repository;

use App\CQRS\EloquentEventStore\Model\EventStore;
use App\CQRS\Serializer\EventSerializer;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class EventStoreRepository
{
    protected $eventSerializer;

    public function __construct(EventSerializer $eventSerializer)
    {
        $this->eventSerializer = $eventSerializer;
    }

    public function append($uuid, SerializableEvent $event, Carbon $recordedOn)
    {
        $message = new EventStore;
        $message->uuid = $uuid;
        $message->event = json_encode(
            $this->eventSerializer->serialize($event)
        );
        $message->recorded_on = $recordedOn;
        $message->save();
    }

    public function load($uuid) : Collection
    {
        $messages = self::where('uuid', $uuid)->get();
        $events = new Collection([]);

        foreach ($messages as $message) {
            $events[] = $this->eventSerializer->deserialize(
                json_decode($message->payload)
            );
        }

        return $events;
    }
}
