<?php

namespace Tests\Unit;

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
    public function can_get_formatted_date() {
        $concert = Concert::factory()->make([
            'date' => Carbon::parse('2021-09-01 9:00pm'),
        ]);

        $this->assertEquals('September 1, 2021', $concert->formatted_date);
    }

    /** @test */
    public function can_get_formatted_start_time() {
        $concert = Concert::factory()->make([
            'date' => Carbon::parse('2021-09-01 09:00:00'),
        ]);

        $this->assertEquals('9:00am', $concert->formatted_start_time);
    }


    /** @test */
    public function can_get_price_in_dollars() {
        $concert = Concert::factory()->make([
            'price' => 40020
        ]);

        $this->assertEquals('400.20', $concert->price_in_dollars);
    }

    /** @test */
    public function concerts_with_published_at_are_published() {
        $concertA = Concert::factory()->create(['published_at' => Carbon::parse('-2 weeks')]);
        $concertB = Concert::factory()->create(['published_at' => Carbon::parse('-1 weeks')]);
        $concertC = Concert::factory()->unpublished()->create();

        $published_concerts = Concert::published()->get();

        $this->assertTrue($published_concerts->contains($concertA));
        $this->assertTrue($published_concerts->contains($concertB));
        $this->assertFalse($published_concerts->contains($concertC));
    }

    /** @test */
    public function can_order_concert_tickets() {
        $concert = Concert::factory()->create();

        $order = $concert->orderTickets('jane@example.com', 3);

        $this->assertEquals('jane@example.com', $order->email);
        $this->assertEquals(3, $order->email);

    }
 }
