<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Concert;

class ConcertController extends Controller
{
    public function show($id) {
        $concert = Concert::find($id);

        return view('concert.view', compact('concert'));
    }


    public function bla() {
        $concert = Concert::factory()->make([
            'date' => Carbon::parse('2021-09-01 9:00pm'),
        ]);

        dd($concert);
    }
}
