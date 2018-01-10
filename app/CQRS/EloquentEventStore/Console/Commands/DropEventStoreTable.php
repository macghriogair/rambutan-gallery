<?php

declare(strict_types=1);

namespace App\CQRS\EloquentEventStore\Console\Commands;

use App\CQRS\EloquentEventStore\Schema\EventStoreSchema;
use Illuminate\Console\Command;

class DropEventStoreTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'eventstore:drop';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Drop the event store table from database.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (app()->environment('prod')) {
            $this->error('I just saved your job!');
            return 1;
        }

        $this->warn('Warning: Dropping the event store table!');
        EventStoreSchema::down();

        $this->info('Done!');
    }
}
