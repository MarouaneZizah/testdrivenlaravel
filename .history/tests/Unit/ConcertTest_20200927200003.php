<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Concert;
use Carbon\Carbon;

class ConcertTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCanGetFormattedDate()
    {
        $concert = Concert::create([
            'title'                => 'Title',
            'subtitle'             => 'subtitle',
            'date'                 => Carbon::createFromFormat('d/m/Y H:i', '15/02/2021 09:00'),
        ]);

    }
}
