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

        $this->paymentGateway = new FakePaymentGateway;
        $this->app->instance(PaymentGatewayInterface::class, $this->paymentGateway);
    }

    /** @test */
    public function customer_can_purchase_concert_tickets() {
        $concert = Concert::factory()->published()->create([
            'price' => 3250
        ]);

        $response = $this->postJson("concert/$concert->id/orders", [
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

        $this->response->assertJsonValidationErrors('email');
        
        $this->assertArrayHasKey('email', $this->decodeResponseJson());
    }
}
