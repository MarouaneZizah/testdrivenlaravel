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
        $concert = Concert::factory()->create([
            'date' => Carbon::parse('2021-09-01 9:00pm'),
        ]);

        $this->assertEquals('September 1, 2021', $concert->formatted_date);
    }
}
