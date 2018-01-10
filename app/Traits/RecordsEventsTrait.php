<?php

namespace App\Traits;

trait RecordsEventsTrait
{
    private $recordedEvents = [];

    public static function bootRecordedEventsTrait()
    {
        static::saving(function (/*RecordsEvents*/ $model) {
            foreach ($post->getRecordedEvents() as $event) {
                event($event);
            }
        });
    }

    public function getRecordedEvents()
    {
        return $this->recordedEvents;
    }

    protected function recordEvent($event)
    {
        $this->handle($event);
        $this->recordedEvents[] = $event;
    }

    protected function handle($event)
    {
        $method = $this->toHandlerMethod($event);

        if (! method_exists($this, $method)) {
            return;
        }

        $this->$method($event);
    }

    private function toHandlerMethod($event) : string
    {
        $classParts = explode('\\', get_class($event));

        return 'apply' . end($classParts);
    }
}
