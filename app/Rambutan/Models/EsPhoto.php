<?php

/**
 * @date    2018-01-09
 * @file    EsPhoto.php
 * @author  Patrick Mac Gregor <pmacgregor@3pc.de>
 */

namespace App\Rambutan\Models;

use App\Models\Photo;
use App\Traits\RecordsEventsTrait;

class EsPhoto extends Photo /* implements RecordsEvents, AppliesRecordedEvents*/
{
    use App\Traits\RecordsEventsTrait;

    public function applyPhotoWasCreated(PhotoWasCreated $event)
    {
        $this->id = $event->id;
    }

    public function publish()
    {
        $this->is_public = true;

        $this->recordEvent(new PhotoWasPublished(
            $this->id,
            $tag
        ));
    }

    public function addTag($tag)
    {
        if (isset($this->tags[$tag])) {
            return;
        }

        //$this->tags[$tag] = true;

        $this->recordEvent(new PhotoWasTagged(
            $this->id,
            $tag
        ));
    }

    public function applyPhotoWasTagged(PhotoWasTagged $event)
    {
        $this->tags[$event->tag] = true;
    }

    public function removeTag($tag)
    {
        if (! isset($this->tags[$tag])) {
            return;
        }

        //unset($this->tags[$tag]);

        $this->recordEvent(new PhotoWasUntagged(
            $this->id,
            $tag
        ));
    }

    public function applyPhotoWasUntagged(PhotoWasUntagged $event)
    {
        unset($this->tags[$event->tag]);
    }
}
