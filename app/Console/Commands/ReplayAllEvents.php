<?php

namespace App\Console\Commands;

use App\Rambutan\Album\ReadModel\ReadAlbum;
use App\Rambutan\Photo\ReadModel\ReadPhoto;
use Illuminate\Console\Command;

/**
 * Inspired by @willemjanz
 * cf. http://labs.qandidate.com/blog/2015/07/08/replaying-event-streams-with-broadway/
 */
class ReplayAllEvents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rambutan:replay:all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Drops Photo Read Model and replay all events';


    private $eventBus;
    private $connection;
    private $payloadSerializer;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        \Broadway\EventHandling\EventBus $eventBus,
        \Doctrine\DBAL\Connection $connection,
        \Broadway\Serializer\Serializer$payloadSerializer
    ) {
        parent::__construct();

        $this->connection = $connection;
        $this->payloadSerializer = $payloadSerializer;
        $this->eventBus = $eventBus;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->comment('Truncate ReadPhoto table...');
        ReadPhoto::truncate();
        $this->comment('Truncate ReadAlbum table...');
        ReadAlbum::truncate();

        $this->comment('Fetch event messages...');
        $events = $this->getEventMessages();

        $this->comment('Re-Publish event for projectors...');
        $this->eventBus->publish(
            new \Broadway\Domain\DomainEventStream($events)
        );
        // OR: There might be cases, were we want only specific projectors applied. There we need a new Bus & subscribe only those projectors we need.
        // $eventBus = new Broadway\EventHandling\SimpleEventBus();
        // $eventBus->subscribe($projector);

        $this->info('Read models have been re-built!');
    }

    protected function getEventMessages()
    {
        $events = [];

        foreach ($this->connection->fetchAll('SELECT * FROM event_store') as $event) {
            $events[] = new \Broadway\Domain\DomainMessage(
                $event['uuid'],
                $event['playhead'],
                new \Broadway\Domain\Metadata(),
                $this->payloadSerializer->deserialize(json_decode($event['payload'], true)),
                \Broadway\Domain\DateTime::fromString($event['recorded_on'])
            );
        }

        return $events;
    }
}
