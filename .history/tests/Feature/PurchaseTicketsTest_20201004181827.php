<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Concert;
use App\Billing\PaymentGatewayInterface;
use App\Billing\FakePaymentGateway;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PurchaseTicketsTest extends TestCase {
    use DatabaseMigrations;

    protected function setUp(): void {
        parent::setUp();

        // Bind the FakePaymentGateway class to the PaymentGateway interface
        // so we can type hint the interface in the controller methods. This
        // should probably be moved to a service provider though.
        $this->paymentGateway = new FakePaymentGateway;
        $this->app->instance(PaymentGatewayInterface::class, $this->paymentGateway);
    }

    private function orderTickets($concert, $params)
    {
        $this->postJson("/concert/{$concert->id}/orders", $params);
    }

    /** @test */
    public function customer_can_purchase_concert_tickets() {
        $concert = Concert::factory()->published()->create([
            'price' => 3250
        ]);

        $response = $this->orderTickets($concert, [
            'email'             => 'john@example.org',
            'ticket_quantity'   => 3,
            'payment_token'     => $this->paymentGateway->getValidTestToken()
        ]);

        $response->assertStatus(201);

        $this->assertEquals(9750, $this->paymentGateway->totalCharges());

        $order = $concert->orders()->where('email', 'john@example.org')->first();
        $this->assertNotNull($order);
        $this->assertEquals(3, $order->tickets()->count());
    }

    /** @test */
    public function email_is_required_to_purchase_tickets() {
        $concert = Concert::factory()->create();

        $response = $this->postJson("concert/$concert->id/orders", [
            'ticket_quantity' => 3,
            'payment_token'   => $this->paymentGateway->getValidTestToken(),
        ]);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors('email');
    }
}
