<?php

/**
 * @date    2018-01-16
 * @file    AddPhotoTest.php
 * @author  Patrick Mac Gregor <macgregor.porta@gmail.com>
 */

namespace Tests\Feature;

class AddPhotoTest extends FeatureTestBase
{
    /** @test */
    public function it_adds_a_photo()
    {
        $uuid = '00000000-0000-0000-0000-000000000000';
        $this->mockUuid($uuid);
        $response = $this->json('POST', route('photo.add'), [
            'name' => 'My Photo',
            'description' => 'Lorem Ipsum'
        ])
        ->assertStatus(201)
        ->assertJsonFragment(['id' => $uuid]);

        $this->assertDatabaseHas('event_store', [
            'uuid' => $uuid,
            'playhead' => 0,
            'type' => 'App.Rambutan.Photo.Events.PhotoWasAdded'
        ]);
    }
}
