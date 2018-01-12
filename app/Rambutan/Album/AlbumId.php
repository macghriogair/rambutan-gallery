<?php

namespace App\Rambutan\Album;

use Webmozart\Assert\Assert;

final class AlbumId
{
    private $albumId;

    /**
     * @param string $albumId
     */
    public function __construct($albumId)
    {
        Assert::string($albumId);
        Assert::uuid($albumId);

        $this->albumId = $albumId;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->albumId;
    }
}
