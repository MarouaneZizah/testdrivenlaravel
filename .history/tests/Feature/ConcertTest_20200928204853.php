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
