<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Concert;
use Carbon\Carbon;

class ConcertController extends Controller
{
    public function show($id) {
        $concert = Concert::find($id);

        return view('concert.view', compact('concert'));
    }
}
