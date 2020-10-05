<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ConcertTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUserCanSeeConcert()
    {
        $concert = Concert::create[
            "title" => "Title",
            "subtitle" => 'subtitl'
        ]

        $response->assertStatus(200);
    }
}
