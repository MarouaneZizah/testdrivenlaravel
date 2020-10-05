<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Concert;
use App\Billing\FakePaymentGateway;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PurchaseTicketsTest extends TestCase {
    use DatabaseMigrations;

    /** @test */
    public function customer_can_purchase_concert_tickets() {
        $paymentGateway = new FakePaymentGateway;

        $this->app->instance(PaymentGatewayInterface::class, $paymentGateway);

        $concert = Concert::factory()->published()->create([
            'price' => 3250
        ]);

        $response = $this->post("concert/$concert->id/orders", [
            'email'             => 'john@example.org',
            'ticket_quantity'   => 3,
            'payment_token'     => $paymentGateway->getValidTestToken()
        ]);

        $response->assertStatus(201);

        $this->assertEquals(9750, $paymentGateway->totalCharges());

        $order = $concert->orders()->where('email', 'john@example.org')->first();
        $this->assertNotNull($order);
        $this->assertEquals(3, $order->tickets->count());
    }
}
