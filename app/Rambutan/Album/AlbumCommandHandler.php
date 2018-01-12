<?php

/**
 * @date    2018-01-17
 * @file    AlbumCommandHandler.php
 * @author  Patrick Mac Gregor <macgregor.porta@gmail.com>
 */

namespace App\Rambutan\Album;

use App\Rambutan\Album\Commands\AddAlbum;
use App\Rambutan\Album\Commands\DeleteAlbum;
use Broadway\CommandHandling\SimpleCommandHandler;

class AlbumCommandHandler extends SimpleCommandHandler
{
    private $repository;

    public function __construct(AlbumRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handleAddAlbum(AddAlbum $command)
    {
        $album = Album::addAlbum(
            $command->getAlbumId(),
            $command->getName(),
            $command->getDescription()
        );

        $this->repository->save($album);
    }

    public function handleDeleteAlbum(DeleteAlbum $command)
    {
        $album = $this->repository->load($command->getAlbumId());
        $album->delete();

        $this->repository->save($album);
    }
}
