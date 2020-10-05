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
        $ticketQuantity = request('ticket_quantity');
        $token          = request('payment_token');

        $concert = Concert::find($concertId);

        $amount = $ticketQuantity * $concert->ticket_price;

        dd($amount,$concert,$ticketQuantity);

        $this->paymentGateway->charge($amount, $token);

        return response()->json([], 201);
    }
}