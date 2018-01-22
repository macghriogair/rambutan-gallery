<?php

namespace App\Http\Controllers\Read;

use App\Http\Controllers\Controller;
use App\Rambutan\Album\ReadModel\ReadAlbum;
use App\Rambutan\Photo\ReadModel\ReadPhoto;

class AlbumPhotoController extends Controller
{
    public function photosByAlbum(ReadAlbum $readAlbum)
    {
        return ReadPhoto::where('album_id', $readAlbum->uuid)->get();
    }
}
