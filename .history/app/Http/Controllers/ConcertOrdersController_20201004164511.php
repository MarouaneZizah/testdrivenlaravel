<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Concert;
use App\Billing\PaymentGatewayInterface;

class ConcertOrdersController extends Controller {
    private $paymentGateway;

    public function __construct(PaymentGatewayInterface $paymentGateway) {
        $this->paymentGateway = $paymentGateway;
    }

    public function store($concertId) {
        $concert        = Concert::find($concertId);

        $ticketQuantity = request('ticket_quantity');
        $token          = request('payment_token');

        $amount         = $ticketQuantity * $concert->ticket_price;

        $this->paymentGateway->charge($amount, $token);

        return response()->json([], 201);
    }
}
