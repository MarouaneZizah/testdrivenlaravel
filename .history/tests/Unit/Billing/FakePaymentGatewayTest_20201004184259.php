<?php

//namespace Tests\Unit\Billing;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use App\Models\Concert;
use Carbon\Carbon;
use App\Billing\FakePaymentGateway;
use App\Billing\PaymentFailedException;

class FakePaymentGatewayTest extends TestCase {

    /** @test */
    public function charges_with_a_valid_token_are_successful() {
        $paymentGateway = new FakePaymentGateway;

        $paymentGateway->charge(2500, $paymentGateway->getValidTestToken());

        $this->assertEquals(2500, $paymentGateway->totalCharges());
    }

     /** @test */
     function charges_with_an_invalid_payment_token_fail()
     {
}try {
    $paymentGateway = new FakePaymentGateway;
    $paymentGateway->charge(2500, 'invalid-payment-token');
} catch (PaymentFailedException $e) {
    return;
}

$this->fail();
}
