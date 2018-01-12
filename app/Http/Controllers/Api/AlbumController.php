<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\StorageAwareController;
use App\Rambutan\Album\AlbumId;
use App\Rambutan\Album\Commands\AddAlbum;
use App\Rambutan\Album\Commands\DeleteAlbum;
use Illuminate\Http\Request;

class AlbumController extends StorageAwareController
{
    public function store(Request $request)
    {
        // TODO
        // Validate input
        // Generate ID
        $albumId = new AlbumId($this->uuidGenerator->generate());
        // Get Command Instance
        $command = new AddAlbum([
            'albumId' => $albumId,
            'name' => $request->name,
            'description' => $request->description
        ]);

        // Dispatch command to Bus
        $this->commandBus->dispatch($command);

        return response()->json([
            'id' => (string) $albumId
        ], 201);
    }

    public function destroy(AlbumId $albumId)
    {
        $this->commandBus->dispatch(new DeleteAlbum([
            'albumId' => $albumId
        ]));

        return response()->json([
            'success' => true
        ], 204);
    }
}
