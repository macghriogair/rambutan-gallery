<?php

/**
 * @date    2018-01-17
 * @file    FeatureTestBase.php
 * @author  Patrick Mac Gregor <macgregor.porta@gmail.com>
 */

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Broadway\UuidGenerator\Testing\MockUuidGenerator;

abstract class FeatureTestBase extends TestCase
{
    use DatabaseMigrations;

    public function mockUuid($uuid)
    {
        app()->singleton(\Broadway\UuidGenerator\UuidGeneratorInterface::class, function () use ($uuid) {
            return new MockUuidGenerator($uuid);
        });

        return $this;
    }
}
