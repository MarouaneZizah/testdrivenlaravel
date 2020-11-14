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

    public function concert() {
        return $this->belongsTo('App\Models\Concert');
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
