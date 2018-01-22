<?php

/**
 * @date    2018-01-18
 * @file    ImageMetadata.php
 * @author  Patrick Mac Gregor <macgregor.porta@gmail.com>
 */

namespace App\Rambutan\Photo;

use Broadway\EventSourcing\SimpleEventSourcedEntity;

class ImageMetadata extends SimpleEventSourcedEntity
{
    private $height = '100';
    private $width;
    private $size;
    private $iso;
    private $aperture;
    private $make;
    private $model;
    private $shutter;
    private $focal;
    private $takestamp;

    /**
     * @return mixed
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @return mixed
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @return mixed
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @return mixed
     */
    public function getIso()
    {
        return $this->iso;
    }

    /**
     * @return mixed
     */
    public function getAperture()
    {
        return $this->aperture;
    }

    /**
     * @return mixed
     */
    public function getMake()
    {
        return $this->make;
    }

    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @return mixed
     */
    public function getShutter()
    {
        return $this->shutter;
    }

    /**
     * @return mixed
     */
    public function getFocal()
    {
        return $this->focal;
    }

    /**
     * @return mixed
     */
    public function getTakestamp()
    {
        return $this->takestamp;
    }
}
