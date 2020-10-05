<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PurchaseTicketsTest extends TestCase
{
    /** @test */
    public function customer_can_purchase_concert_tickets()
    {
        $concert = Concert::factory()->published()->create([
            'price' => 3250
        ]);

        $this->post('')
    }
}
