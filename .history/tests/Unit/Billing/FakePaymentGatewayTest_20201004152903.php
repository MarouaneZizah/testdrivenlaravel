<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use App\Models\Concert;
use Carbon\Carbon;

class FakePaymentGatewayTest extends TestCase {
    use DatabaseMigrations;

    function charges_with_a_valid_token_are_successful() {
        $paymentGateway = new FakePaymentGateway;

        $paymentGateway->charge(2500, $paymentGateway->get)
    }
}
