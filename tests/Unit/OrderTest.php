<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Concert;
use App\Models\Order;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class OrderTest extends TestCase {
    use DatabaseMigrations;

    /** @test */
    public function creating_order_from_ticket_and_email_and_price() {
        $concert = Concert::factory()->create()->addTickets(10);

        $this->assertEquals(10, $concert->ticketsRemaining());

        $tickets = $concert->findTickets(3);
        $order   = Order::forTickets('john@example.com', $tickets, 3600);

        $this->assertEquals('john@example.com', $order->email);
        $this->assertEquals(3, $order->ticketQuantity());
        $this->assertEquals(3600, $order->amount);

        $this->assertEquals(7, $concert->ticketsRemaining());
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
