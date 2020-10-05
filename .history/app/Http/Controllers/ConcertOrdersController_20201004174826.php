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
        dd('ok');
        $this->validate(request(), [
            'email' => 'required',
        ]);

        $ticketQuantity = request('ticket_quantity');
        $token          = request('payment_token');
        $email          = request('email');

        $concert = Concert::find($concertId);

        $this->paymentGateway->charge($ticketQuantity * $concert->price, $token);

        $concert->orderTickets($email, $ticketQuantity);

        return response()->json([], 201);
    }
}
