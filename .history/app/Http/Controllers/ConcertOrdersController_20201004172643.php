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
        $email          = request('email');

        //Get Concert
        $concert = Concert::find($concertId);

        $amount = $ticketQuantity * $concert->price;

        $this->paymentGateway->charge($amount, $token);

        $concert->orderTickets($email, $ticketQuantity);

        return response()->json([], 201);
    }
}
