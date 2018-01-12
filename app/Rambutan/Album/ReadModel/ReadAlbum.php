<?php

/**
 * @date    2018-01-15
 * @file    ReadAlbum.php
 * @author  Patrick Mac Gregor <macgregor.porta@gmail.com>
 */

namespace App\Rambutan\Album\ReadModel;

use App\Rambutan\Album\AlbumId;
use Illuminate\Database\Eloquent\Model;

class ReadAlbum extends Model
{
    protected $table = 'albums';

    protected $casts = [
        'is_public' => 'boolean',
        'tags' => 'array'
    ];

    public static function byUuid(AlbumId $albumId)
    {
        return self::where('uuid', (string) $albumId)->first();
    }
}
