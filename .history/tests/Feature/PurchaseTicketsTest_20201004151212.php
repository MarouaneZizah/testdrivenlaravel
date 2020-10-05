<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PurchaseTicketsTest extends TestCase
{
    /** @test */
    public function customer_can_purchase_concert_tickets()
    {
        $concert = Concert::factory()->published()->create([
            'price' => 3250
        ]);

        $this->post('concert/{$concert->id}/order', [
            'email'             => 'john@example.org',
            'ticket_quantity'   => 3,
            'payment_token'     => $paymentGateway->getValidTestToken()
        ]);

		$this->assertEquals(9750, $paymentGateway->totalCharges());

		$order = $concert->orders()->where('email', )
    }
}
