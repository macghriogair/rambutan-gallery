<?php

namespace App\Http\Controllers\Read;

use App\Http\Controllers\Controller;
use App\Rambutan\Photo\ReadModel\ReadPhoto;

class PhotoController extends Controller
{
    public function index()
    {
        return ReadPhoto::all();
    }

    public function show(ReadPhoto $readPhoto)
    {
        return response()->json(['data' => $readPhoto ]);
    }
}
