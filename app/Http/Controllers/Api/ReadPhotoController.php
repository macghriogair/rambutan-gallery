<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Rambutan\Photo\ReadModel\ReadPhoto;

class ReadPhotoController extends Controller
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
