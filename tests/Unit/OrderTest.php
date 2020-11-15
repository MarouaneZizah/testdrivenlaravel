<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Concert;
use App\Models\Order;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class OrderTest extends TestCase {
    use DatabaseMigrations;

    /** @test */
    public function creating_order_from_ticket_and_email() {

    }

    /** @test */
    public function tickets_are_released_when_an_order_is_cancelled() {
        $concert = Concert::factory()->create()->addTickets(10);
        $order   = $concert->orderTickets('jane@example.com', 5);
        $this->assertEquals(5, $concert->ticketsRemaining());

        $order->cancel();

        $this->assertEquals(10, $concert->ticketsRemaining());
        $this->assertNull(Order::find($order->id));
    }

    /** @test */
    public function converting_to_an_array() {
        $concert = Concert::factory()->create(['price' => 1200])->addTickets(5);
        $order   = $concert->orderTickets('jane@example.com', 5);

        $result = $order->toArray();

        $this->assertEquals([
            'email'           => 'jane@example.com',
            'ticket_quantity' => 5,
            'amount'          => 6000,
        ], $result);
    }
}
