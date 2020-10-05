<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Concert;

class ConcertTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUserCanSeeConcert()
    {
        $concert = Concert::create([
            "title" => "Title",
            "subtitle" => 'subtitl'
        ]);

        $this->visit('concert/' . $concert->id);

        $this->see('Title');

        $response->assertStatus(200);
    }
}
