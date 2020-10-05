<?php

namespace Tests\Feature;

use App\Concert;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Billing\FakePaymentGateway;

class PurchaseTicketsTest extends TestCase {
    /** @test */
    public function customer_can_purchase_concert_tickets() {
        $paymentGateway = new FakePaymentGateway;

        $concert = Concert::factory()->published()->create([
            'price' => 3250
        ]);

        $this->post('concert/{$concert->id}/order', [
            'email'             => 'john@example.org',
            'ticket_quantity'   => 3,
            'payment_token'     => $paymentGateway->getValidTestToken()
        ]);

        $this->assertResponseStatus(201);

        $this->assertEquals(9750, $paymentGateway->totalCharges());

        $order = $concert->orders()->where('email', 'john@example.org')->first();
        $this->assertNotNull($order);
        $this->assertEquals(3, $order->tickets->count());
    }
}
