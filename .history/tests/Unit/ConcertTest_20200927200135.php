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
        $concert = Concert::create([
            'date' => Carbon::createFromFormat('d/m/Y H:i', '15/02/2021 09:00'),
        ]);

        $date  = $concert->formatted_date;

        $this->assertEquals('December 1, 2020', $date);
    }
}