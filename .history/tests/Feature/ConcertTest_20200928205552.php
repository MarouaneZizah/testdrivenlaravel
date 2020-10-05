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
        $concert = Concert::factory()->create([
            'date' => Carbon::parse('2021-09-01 9:00pm'),
        ]);

        $response = $this->visit('concert/' . $concert->id);

        $response->assertSee('Title');
        $response->assertSee('subtitle');
        $response->assertSee('September 1, 2021');
        $response->assertSee('40.00');
        $response->assertSee('Royal theatre');
        $response->assertSee('Marrakesh');
        $response->assertSee('40000');
        $response->assertSee('Call on 0685741239');

        $response->assertStatus(200);
    }


    /** @test */
    public function user_cannot_view_unpublished_concerts() {

    }
}
