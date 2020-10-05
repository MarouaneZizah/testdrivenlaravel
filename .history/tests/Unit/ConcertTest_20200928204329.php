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
        $concert = Concert::factory()->create([
            'date' => Carbon::parse('2021-09-01 9:00pm'),
        ]);

        $this->assertEquals('September 1, 2021', $concert->formatted_date);
    }

    /** @test */
    public function can_get_formatted_start_time() {
        $concert = Concert::factory()->create([
            'date' => Carbon::parse('2021-09-01 09:00:00'),
        ]);

        $this->assertEquals('9:00am', $concert->formatted_start_time);
    }


    /** @test */
    public function can_get_price_in_dollars() {
        $concert = Concert::factory()->create([
            'price' => 40020
        ]);

        $this->assertEquals('400.20', $concert->price_in_dollars);
    }
}
