<?php

declare(strict_types=1);

namespace App\CQRS\EloquentEventStore\Model;

use Illuminate\Database\Eloquent\Model;

class EventStore extends Model
{
    protected $table = 'event_store';

    public $timestamps = false;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['recorded_on'];
}
