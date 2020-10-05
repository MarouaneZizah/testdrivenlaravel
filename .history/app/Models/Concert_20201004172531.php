<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Concert extends Model
{
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

    public function orderTickets($email, $number_of_tickets) {
        $order = $this->orders()->create(['email' => $email]);

        foreach (range(1, $ticketQuantity) as $i) {
            $order->tickets()->create([]);
        }

    }
}
