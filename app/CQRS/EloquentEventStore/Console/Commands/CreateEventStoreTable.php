<?php

declare(strict_types=1);

namespace App\CQRS\EloquentEventStore\Console\Commands;

use App\CQRS\EloquentEventStore\Schema\EventStoreSchema;
use Illuminate\Console\Command;

class CreateEventStoreTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'eventstore:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create the event store table in database.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Creating the event store table');
        EventStoreSchema::up();
        $this->info('Done!');
    }
}
