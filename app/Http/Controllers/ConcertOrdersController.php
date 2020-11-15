<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Concert;
use App\Billing\PaymentGatewayInterface;
use App\Billing\PaymentFailedException;
use App\Exceptions\NotEnoughTicketsException;

class ConcertOrdersController extends Controller {
    private $paymentGateway;

    public function __construct(PaymentGatewayInterface $paymentGateway) {
        $this->paymentGateway = $paymentGateway;
    }

    public function store($concertId) {
        $concert = Concert::published()->findOrFail($concertId);

        $this->validate(request(), [
            'email'           => ['required', 'email'],
            'ticket_quantity' => ['required', 'integer', 'min:1'],
            'payment_token'   => ['required'],
        ]);

        $ticketQuantity = request('ticket_quantity');
        $token          = request('payment_token');
        $email          = request('email');

        try {
            // Find some tickets
            $tickets = $concert->findTickets(request('ticket_quantity'));

            // Charge the customer for the tickets
            $this->paymentGateway->charge(request('ticket_quantity') * $concert->price, request('payment_token'));

            // Create an order for those tickets
            $order = $concert->createOrder(request('email'), $tickets);

            return response()->json($order, 201);
        } catch (PaymentFailedException $e) {
            return response()->json([], 422);
        } catch (NotEnoughTicketsException $e) {
            return response()->json([], 422);
        }
    }
}
