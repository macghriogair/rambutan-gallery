<?php

/**
 * @date    2018-01-15
 * @file    ReadPhoto.php
 * @author  Patrick Mac Gregor <macgregor.porta@gmail.com>
 */

namespace App\Rambutan\Photo\ReadModel;

use App\Rambutan\Photo\PhotoId;
use Illuminate\Database\Eloquent\Model;

class ReadPhoto extends Model
{
    protected $table = 'photos';

    protected $casts = [
        'is_public' => 'boolean',
        'tags' => 'array'
    ];

    public static function byUuid(PhotoId $photoId)
    {
        return self::where('uuid', (string) $photoId)->first();
    }
}
