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
        $concert = Concert::factory()->make();

        $response = $this->get('concert/' . $concert->id);

        $response->assertSee('Title');

        $response->assertStatus(200);
    }
}
