<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Concert extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getFormattedDateAttribute() {
        return $concert->date->format('F j, Y')
    }
}
