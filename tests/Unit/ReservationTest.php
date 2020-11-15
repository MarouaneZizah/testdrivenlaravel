<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Concert;
use App\Models\Reservation;
use App\Exceptions\NotEnoughTicketsException;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReservationTest extends TestCase {
    use DatabaseMigrations;

    /** @test*/
    public function can_calculate_reservation_cost() {
        $concert = Concert::factory()->create(['price' => 1200])->addTickets(5);

        $tickets = $concert->findTickets(2);

        $reservation = new Reservation($tickets);

        $this->assertEquals(2400, $reservation->totalCost());
    }
}
