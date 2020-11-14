<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Exceptions\NotEnoughTicketsException;

class Concert extends Model {
    use HasFactory;

    protected $guarded = [];

    protected $dates = ['date'];

    public function getFormattedDateAttribute() {
        return $this->date->format('F j, Y');
    }

    public function getFormattedStartTimeAttribute() {
        return $this->date->format('g:ia');
    }

    public function getPriceInDollarsAttribute() {
        return number_format($this->price / 100, 2);
    }

    public function scopePublished($query) {
        return $query->WhereNotNull('published_at');
    }

    public function orders() {
        return $this->belongsToMany('App\Models\Order', 'tickets');
    }

    public function tickets() {
        return $this->hasMany('App\Models\Ticket');
    }

    public function orderTickets($email, $ticketQuantity) {
        $tickets = $this->findTickets($ticketQuantity);

        return $this->createOrder($email, $tickets);
    }

    public function findTickets($quantity) {
        $tickets = $this->tickets()->available()->take($quantity)->get();

        if ($tickets->count() < $quantity) {
            throw new NotEnoughTicketsException;
        }

        return $tickets;
    }

    public function createOrder($email, $tickets) {
        $order = Order::create([
            'email'  => $email,
            'amount' => $tickets->sum('price'),
        ]);

        foreach ($tickets as $ticket) {
            $order->tickets()->save($ticket);
        }

        return $order;
    }

    public function addTickets($quantity) {
        foreach (range(1, $quantity) as $i) {
            $this->tickets()->create([]);
        }

        return $this;
    }

    public function ticketsRemaining() {
        return $this->tickets()->available()->count();
    }

    public function hasOrderFor($customerEmail) {
        return $this->orders()->where('email', $customerEmail)->count() > 0;
    }

    public function ordersFor($customerEmail) {
        return $this->orders()->where('email', $customerEmail)->get();
    }
}
