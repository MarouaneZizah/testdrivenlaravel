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
        return $this->hasMany('App\Models\Order');
    }

    public function tickets() {
        return $this->hasMany('App\Models\Ticket');
    }

    public function orderTickets($email, $quantity) {
        $tickets = $this->tickets()->available()->take($quantity)->get();

        if ($tickets->count() < $quantity) {
            throw new NotEnoughTicketsException;
        }

        $order = $this->orders()->create(['email' => $email]);

        foreach ($tickets as $ticket) {
            $order->tickets()->save($ticket);
        }

        return $order;
    }

    public function addTickets($quantity) {
        foreach (range(1, $quantity) as $i) {
            $this->tickets()->create([]);
        }
    }

    public function ticketsRemaining() {
        return $this->tickets()->available()->count();
    }
}
