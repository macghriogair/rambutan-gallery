<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Rambutan\Album\ReadModel\ReadAlbum;

class ReadAlbumController extends Controller
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
