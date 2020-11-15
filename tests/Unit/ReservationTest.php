<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Reservation;
use App\Exceptions\NotEnoughTicketsException;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReservationTest extends TestCase {
    /** @test*/
    public function can_calculate_reservation_cost() {
        $tickets = collect([
            (object) ['price' => 1200],
            (object) ['price' => 1200],
            (object) ['price' => 1200],
        ]);

        $reservation = new Reservation($tickets);

        $this->assertEquals(3600, $reservation->totalCost());
    }
}
