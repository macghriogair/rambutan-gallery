<?php

declare(strict_types=1);

namespace App\CQRS\EloquentEventStore\Schema;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class EventStoreSchema
{
    public static function up(string $tableName = 'event_store')
    {
        if (! Schema::hasTable($tableName)) {
            Schema::create($tableName, function (Blueprint $table) {
                $table->increments('id');
                $table->char('uuid', 36);
                $table->integer('playhead')->unsigned();
                $table->text('event');
                $table->text('metadata')->nullable();
                $table->timestamp('recorded_on');
                $table->unique(['uuid', 'playhead']);
            });
        }
    }

    public static function down(string $tableName = 'event_store')
    {
        Schema::dropIfExists($tableName);
    }
}
