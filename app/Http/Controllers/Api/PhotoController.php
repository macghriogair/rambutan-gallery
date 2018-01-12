<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\StorageAwareController;
use App\Rambutan\Album\AlbumId;
use App\Rambutan\Photo\Commands\AddPhoto;
use App\Rambutan\Photo\Commands\AddPhotoToAlbum;
use App\Rambutan\Photo\Commands\DeletePhoto;
use App\Rambutan\Photo\Commands\TagPhoto;
use App\Rambutan\Photo\Commands\UntagPhoto;
use App\Rambutan\Photo\PhotoId;
use Illuminate\Http\Request;

class PhotoController extends StorageAwareController
{
    public function store(Request $request)
    {
        $input = $request->validate([
            // 'file' => 'required|mimes:jpeg,bmp,png',
            'name' => 'string|max:100',
            'description' => 'sometimes'
        ]);

        // Validate input
        // Store File...
        // Generate ID
        $photoId = new PhotoId($this->uuidGenerator->generate());
        // Get Command Instance
        $command = new AddPhoto([
            'photoId' => $photoId,
            // 'file' => $input['file'],
            'name' => $input['name'],
            'description' => $input['description']
        ]);

        // Dispatch command to Bus
        $this->commandBus->dispatch($command);

        return response()->json([
            'id' => (string) $photoId
        ], 201);
    }

    public function tagPhoto(PhotoId $photoId, Request $request)
    {
        $input = $request->validate([
            'tag' => 'required|string|max:100'
        ]);

        $command = new TagPhoto([
            'photoId' => $photoId,
            'tag' => $input['tag']
        ]);
        // Dispatch command to Bus
        $this->commandBus->dispatch($command);

        return response()->json([
            'success' => true
        ]);
    }

    public function untagPhoto(PhotoId $photoId, Request $request)
    {
        $input = $request->validate([
            'tag' => 'required|string|max:100'
        ]);

        $command = new UntagPhoto([
            'photoId' => $photoId,
            'tag' => $input['tag']
        ]);
        // Dispatch command to Bus
        $this->commandBus->dispatch($command);

        return response()->json([
            'success' => true
        ]);
    }

    public function addToAlbum(PhotoId $photoId, Request $request)
    {
        $input = $request->validate([
            'album_id' => 'required|string'
        ]);
        $albumId = new AlbumId($input['album_id']);

        $this->commandBus->dispatch(new AddPhotoToAlbum([
            'photoId' => $photoId,
            'albumId' => $albumId
        ]));

        return response()->json([
            'success' => true
        ]);
    }

    public function destroy(PhotoId $photoId)
    {
        $this->commandBus->dispatch(new DeletePhoto([
            'photoId' => $photoId
        ]));

        return response()->json([
            'success' => true
        ], 204);
    }
}
