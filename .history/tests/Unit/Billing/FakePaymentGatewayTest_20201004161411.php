<?php

//namespace Tests\Unit\Billing;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use App\Models\Concert;
use Carbon\Carbon;
use App\Billing\FakePaymentGateway;

class FakePaymentGatewayTest extends TestCase {

    /** @test */
    public function charges_with_a_valid_token_are_successful() {
        $paymentGateway = new FakePaymentGateway;

        $paymentGateway->charge(2500, $paymentGateway->getValidTestToken());

        $this->assertEquals(2000, $paymentGateway->totalCharges());
    }
}
