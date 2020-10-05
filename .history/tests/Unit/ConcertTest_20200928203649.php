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
     */
    public function testCanGetFormattedDate() {
        $concert = Concert::factory()->create([
            'date' => Carbon::parse('2021-09-01 9:00pm'),
        ]);

        $this->assertEquals('September 1, 2021', $concert->formatted_date);
    }

    /** @test */
    public function cab_get_formatted_start_time() {
        $concert = Concert::factory()->create([
            'date' => Carbon::parse('2021-09-01 09:00:00'),
        ]);

        $this->assertEquals('9:00pm', $concert->formatted_date);
    }
}
