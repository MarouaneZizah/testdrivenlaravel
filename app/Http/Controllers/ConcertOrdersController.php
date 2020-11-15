<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Concert;
use App\Models\Reservation;
use Illuminate\Http\Request;
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

        try {
            $ticket_quantity = request('ticket_quantity');
            $email           = request('email');
            $token           = request('payment_token');

            // Find some tickets
            $tickets = $concert->findTickets($ticket_quantity);

            $reservation = new Reservation($tickets);
            $price       = $reservation->totalCost();

            // Charge the customer for the tickets
            $this->paymentGateway->charge($price, $token);

            // Create an order for those tickets
            $order = Order::forTickets($email, $tickets, $price);

            return response()->json($order, 201);
        } catch (PaymentFailedException $e) {
            return response()->json([], 422);
        } catch (NotEnoughTicketsException $e) {
            return response()->json([], 422);
        }
    }
}
