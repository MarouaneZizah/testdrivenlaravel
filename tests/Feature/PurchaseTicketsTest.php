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

    private function orderTickets($concert, $params) {
        return $this->postJson("/concert/{$concert->id}/orders", $params);
    }

    /** @test */
    public function customer_can_purchase_tickets_to_a_published_concert() {
        $concert = Concert::factory()->published()->create(['price' => 3250]);
        $concert->addTickets(3);

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
    function cannot_purchase_tickets_to_an_unpublished_concert()
    {
        $concert = Concert::factory()->unpublished()->create();
        $concert->addTickets(3);

        $response = $this->orderTickets($concert, [
            'email' => 'john@example.com',
            'ticket_quantity' => 3,
            'payment_token' => $this->paymentGateway->getValidTestToken(),
        ]);

        $response->assertStatus(404);
        $this->assertEquals(0, $concert->orders()->count());
        $this->assertEquals(0, $this->paymentGateway->totalCharges());
    }

    /** @test */
    public function an_order_is_not_created_if_payment_fails() {
        $concert = Concert::factory()->published()->create(['price' => 3250]);
        $concert->addTickets(3);

        $response = $this->orderTickets($concert, [
            'email'           => 'john@example.com',
            'ticket_quantity' => 3,
            'payment_token'   => 'invalid-payment-token',
        ]);

        $response->assertStatus(422);

        $order = $concert->orders()->where('email', 'john@example.com')->first();

        $this->assertNull($order);
    }

    /** @test */
    public function email_is_required_to_purchase_tickets() {
        $concert = Concert::factory()->published()->create();

        $response = $this->orderTickets($concert, [
            'ticket_quantity' => 3,
            'payment_token'   => $this->paymentGateway->getValidTestToken(),
        ]);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors('email');
    }

    /** @test */
    public function email_must_be_valid_to_purchase_tickets() {
        $concert = Concert::factory()->published()->create();

        $response = $this->orderTickets($concert, [
            'email'           => 'not-an-email-address',
            'ticket_quantity' => 3,
            'payment_token'   => $this->paymentGateway->getValidTestToken(),
        ]);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors('email');
    }

    /** @test */
    public function ticket_quantity_is_required_to_purchase_tickets() {
        $concert = Concert::factory()->published()->create();

        $response = $this->orderTickets($concert, [
            'email'         => 'john@example.com',
            'payment_token' => $this->paymentGateway->getValidTestToken(),
        ]);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors('ticket_quantity');
    }

    /** @test */
    public function ticket_quantity_must_be_at_least_1_to_purchase_tickets() {
        $concert = Concert::factory()->published()->create();

        $response = $this->orderTickets($concert, [
            'email'           => 'john@example.com',
            'ticket_quantity' => 0,
            'payment_token'   => $this->paymentGateway->getValidTestToken(),
        ]);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors('ticket_quantity');
    }

    /** @test */
    public function payment_token_is_required() {
        $concert = Concert::factory()->published()->create();

        $response = $this->orderTickets($concert, [
            'email'           => 'john@example.com',
            'ticket_quantity' => 3,
        ]);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors('payment_token');
	}

    /** @test */
	function cannot_purchase_more_tickets_than_remain()
    {
        $concert = Concert::factory()->published()->create();
        $concert->addTickets(50);

        $response = $this->orderTickets($concert, [
            'email' => 'john@example.com',
            'ticket_quantity' => 51,
            'payment_token' => $this->paymentGateway->getValidTestToken(),
        ]);

		$response->assertStatus(422);

        $order = $concert->orders()->where('email', 'john@example.com')->first();
        $this->assertNull($order);
        $this->assertEquals(0, $this->paymentGateway->totalCharges());
        $this->assertEquals(50, $concert->ticketsRemaining());
    }
}
