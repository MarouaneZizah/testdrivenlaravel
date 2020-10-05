<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Concert;

class ConcertTest extends TestCase {
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUserCanSeeConcert() {
        $concert = Concert::create([
            'title'    => 'Title',
            'subtitle' => 'subtitle',
            'date' => Carbon::parse('15/02/2021 09:00'),
            'price' => 
        ]);

        $this->visit('concert/' . $concert->id);

        $this->see('Title');

        $response->assertStatus(200);
    }
}
