<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use PHPUnit\Framework\TestCase;
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
        $concert = Concert::factory()->make([
            'date' => Carbon::parse('2021-09-01 9:00pm'),
        ]);

        dd($concert);

        $date = $concert->formatted_date;

        $this->assertEquals('September 1, 2021', $date);
    }
}
