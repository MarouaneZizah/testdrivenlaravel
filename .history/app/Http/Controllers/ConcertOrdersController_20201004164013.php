<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Concert;
use App\Billing\PaymentGatewayInterface;

class ConcertOrdersController extends Controller {
    private $paymentGateway;

    public function __construct(PaymentGatewayInterface $paymentGateway) {
        $this->paymentGateway = $paymentGateway;
    }

    public function store($concertId) {
        $concert        = Concert::find($concertId);
        $ticketQuantity = request('ticket_quantity');
        $amount         = $ticketQuantity * $concert->ticket_price;
        $token          = request('payment_token');
        $this->paymentGateway->charge($amount, $token);
        return response()->json([], 201);
    }
}
