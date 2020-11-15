<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model {
    use HasFactory;

    protected $guarded = [];

    public function tickets() {
        return $this->hasMany('App\Models\Ticket');
    }

    public static function forTickets($email, $tickets, $amount) {
        $order = self::create([
            'email'  => $email,
            'amount' => $amount,
        ]);

        foreach ($tickets as $ticket) {
            $order->tickets()->save($ticket);
        }

        return $order;
    }

    public function concert(): HasOneThrough
    {
        return $this->hasOneThrough(Concert::class, Ticket::class, 'concert_id', 'id');
    }

    public function cancel() {
        foreach ($this->tickets as $ticket) {
            $ticket->release();
        }

        $this->delete();
    }

    public function ticketQuantity() {
        if ($this->relationLoaded('tickets')) {
            return $this->tickets->count();
        }

        return $this->tickets()->count();
    }

    public function toArray() {
        return [
            'email'           => $this->email,
            'ticket_quantity' => $this->ticketQuantity(),
            'amount'          => $this->amount,
        ];
    }
}
