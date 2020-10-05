<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Concert;
use Carbon\Carbon;

class ConcertTest extends TestCase {
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUserCanSeeConcert() {
        $concert = Concert::create([
            'title'                => 'Title',
            'subtitle'             => 'subtitle',
            'date'                 => Carbon::createFromFormat('Y-m-d/m/Y ', '15/02/2021 09:00'),
            'price'                => 4000,
            'adresse'              => 'Royal theatre',
            'City'                 => 'Marrakesh',
            'zip'                  => '40000',
            'additional_info'      => 'Call on 0685741239',
        ]);

        $this->visit('concert/' . $concert->id);

        $this->see('Title');

        $response->assertStatus(200);
    }
}
