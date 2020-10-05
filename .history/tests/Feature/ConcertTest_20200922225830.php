<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use App\Models\Concert;
use Carbon\Carbon;

class ConcertTest extends TestCase {

    use DatabaseMigrations;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUserCanSeeConcert() {
        $concert = Concert::create([
            'title'                => 'Title',
            'subtitle'             => 'subtitle',
            'date'                 => Carbon::createFromFormat('d/m/Y H:i', '15/02/2021 09:00'),
            'price'                => 4000,
            'adresse'              => 'Royal theatre',
            'City'                 => 'Marrakesh',
            'zip'                  => '40000',
            'additional_info'      => 'Call on 0685741239',
        ]);

        $response = $this->get('concert/' . $concert->id);

        $response->see('Title');

        $response->assertStatus(200);
    }
}
