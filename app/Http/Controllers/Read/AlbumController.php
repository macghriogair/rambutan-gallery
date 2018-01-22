<?php

namespace App\Http\Controllers\Read;

use App\Http\Controllers\Controller;
use App\Rambutan\Album\ReadModel\ReadAlbum;

class AlbumController extends Controller
{
    public function index()
    {
        return ReadAlbum::all();
    }

    public function show(ReadAlbum $readAlbum)
    {
        return response()->json(['data' => $readAlbum ]);
    }
}
