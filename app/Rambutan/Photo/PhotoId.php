<?php

namespace App\Rambutan\Photo;

use Webmozart\Assert\Assert;

final class PhotoId
{
    private $photoId;

    /**
     * @param string $photoId
     */
    public function __construct($photoId)
    {
        Assert::string($photoId);
        Assert::uuid($photoId);

        $this->photoId = $photoId;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->photoId;
    }
}
