<?php

/**
 * @date    2018-01-15
 * @file    PhotoIdTest.php
 * @author  Patrick Mac Gregor <pmacgregor@3pc.de>
 */

namespace Tests\Rambutan;

use App\Rambutan\Photo\PhotoId;

class PhotoIdTest extends \PHPUnit\Framework\TestCase
{
    /** @test */
    public function it_is_instantiated_with_uuid()
    {
        $uuid = '00000000-0000-0000-0000-000000000000';
        $id = new PhotoId($uuid);

        $this->assertEquals($uuid, (string) $id);
    }

    /** @test */
    public function it_asserts_uuid()
    {
        $this->expectException(\InvalidArgumentException::class);
        new PhotoId('abc123');
    }
}
