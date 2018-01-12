<?php

/**
 * @date    2018-01-16
 * @file    AddAlbumTest.php
 * @author  Patrick Mac Gregor <macgregor.porta@gmail.com>
 */

namespace Tests\Feature;

class AddAlbumTest extends FeatureTestBase
{
    /** @test */
    public function it_adds_an_album()
    {
        $uuid = '00000000-0000-0000-0000-000000000000';
        $this->mockUuid($uuid);

        $response = $this->json('POST', route('album.add'), [
            'name' => 'My Album',
            'description' => 'Lorem Ipsum'
        ])
        ->assertStatus(201)
        ->assertJsonFragment(['id' => $uuid]);

        $this->assertDatabaseHas('event_store', [
            'uuid' => $uuid,
            'playhead' => 0,
            'type' => 'App.Rambutan.Album.Events.AlbumWasAdded'
        ]);
    }
}
