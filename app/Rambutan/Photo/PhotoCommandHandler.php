<?php

/**
 * @date    2018-01-15
 * @file    PhotoCommandHandler.php
 * @author  Patrick Mac Gregor <macgregor.porta@gmail.com>
 */

namespace App\Rambutan\Photo;

use App\Rambutan\Photo\Commands\AddPhoto;
use App\Rambutan\Photo\Commands\AddPhotoToAlbum;
use App\Rambutan\Photo\Commands\DeletePhoto;
use App\Rambutan\Photo\Commands\DescribePhoto;
use App\Rambutan\Photo\Commands\TagPhoto;
use App\Rambutan\Photo\Commands\UntagPhoto;
use Broadway\CommandHandling\SimpleCommandHandler;

class PhotoCommandHandler extends SimpleCommandHandler
{
    private $repository;

    public function __construct(PhotoRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handleAddPhoto(AddPhoto $command)
    {
        // $file = $command->getFile();
        // $url = Storage::disk('local')->put($file);

        $photo = Photo::addPhoto(
            $command->getPhotoId(),
            $command->getAlbumId(),
            $command->getName(),
            $command->getDescription()
        );

        $this->repository->save($photo);
    }

    public function handleTagPhoto(TagPhoto $command)
    {
        /* @var Photo $photo */
        $photo = $this->repository->load($command->getPhotoId());
        $photo->addTag($command->getTag());

        $this->repository->save($photo);
    }

    public function handleUntagPhoto(UntagPhoto $command)
    {
        /* @var Photo $photo */
        $photo = $this->repository->load($command->getPhotoId());
        $photo->removeTag($command->getTag());

        $this->repository->save($photo);
    }

    public function handleDescribePhoto(DescribePhoto $command)
    {
        /* @var Photo $photo */
        $photo = $this->repository->load($command->getPhotoId());
        $photo->describe($command->getDescription());

        $this->repository->save($photo);
    }

    public function handleDeletePhoto(DeletePhoto $command)
    {
        $photo = $this->repository->load($command->getPhotoId());
        $photo->delete();

        $this->repository->save($photo);
    }

    public function handleAddPhotoToAlbum(AddPhotoToAlbum $command)
    {
        $photo = $this->repository->load($command->getPhotoId());
        $photo->addToAlbum($command->getAlbumId());

        $this->repository->save($photo);
    }
}
