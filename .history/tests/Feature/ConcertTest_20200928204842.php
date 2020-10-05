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
     * @test
     */
    public function user_can_see_concert() {
        $concert = Concert::factory()->create();

        $response = $this->get('concert/' . $concert->id);


        'title'                => 'Title',
        'subtitle'             => 'subtitle',
        'date'                 => Carbon::parse('+2 weeks'),
        'price'                => 4000,
        'adresse'              => 'Royal theatre',
        'City'                 => 'Marrakesh',
        'zip'                  => '40000',
        'additional_info'      => 'Call on 0685741239',

        $response->assertSee('Title');
        $response->assertSee('subtitle');
        $response->assertSee('Title');
        $response->assertSee('40.00');
        $response->assertSee('Royal theatre');
        $response->assertSee('Marrakesh');
        $response->assertSee('40000');
        $response->assertSee('Call on 0685741239');

        $response->assertStatus(200);
    }
}
