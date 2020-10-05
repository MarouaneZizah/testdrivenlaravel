<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Concert;
use App\Billing\PaymentGatewayInterface;
use App\Billing\PaymentFailedException;

class ConcertOrdersController extends Controller {
    private $paymentGateway;

    public function __construct(PaymentGatewayInterface $paymentGateway) {
        $this->paymentGateway = $paymentGateway;
    }

    public function store($concertId) {
        $this->validate(request(), [
            'email'           => ['required', 'email'],
            'ticket_quantity' => ['required', 'integer', 'min:1'],
            'payment_token'   => ['required'],
        ]);

        $ticketQuantity = request('ticket_quantity');
        $token          = request('payment_token');
        $email          = request('email');

        try {
            $concert = Concert::find($concertId);
            $this->paymentGateway->charge($ticketQuantity * $concert->price, $token);
            $concert->orderTickets($email, $ticketQuantity);

            return response()->json([], 201);
        } catch (PaymentFailedException $e) {
            return response()->json([], 422);
        }
    }
}
