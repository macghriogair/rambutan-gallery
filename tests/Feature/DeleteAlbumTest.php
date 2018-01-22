<?php

/**
 * @date    2018-01-16
 * @file    DeleteAlbumTest.php
 * @author  Patrick Mac Gregor <macgregor.porta@gmail.com>
 */

namespace Tests\Feature;

class DeleteAlbumTest extends FeatureTestBase
{
    /** @test */
    public function it_deletes_an_album()
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

        $response = $this->json('DELETE', route('album.destroy', ['albumId' => $uuid]))
        ->assertStatus(204);
        $this->assertDatabaseHas('event_store', [
            'uuid' => $uuid,
            'playhead' => 1,
            'type' => 'App.Rambutan.Album.Events.AlbumWasDeleted'
        ]);
    }
}
