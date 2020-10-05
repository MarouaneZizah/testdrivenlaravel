<?php

namespace Database\Factories;

use App\Models\Concert;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ConcertFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Concert::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title'                => 'Title',
            'subtitle'             => 'subtitle',
            'date'                 => Carbon::parse('+2 weeks'),
            'published_at'         => Carbon::parse('-1 week'),
            'price'                => 4000,
            'adresse'              => 'Royal theatre',
            'City'                 => 'Marrakesh',
            'zip'                  => '40000',
            'additional_info'      => 'Call on 0685741239',
        ];
    }

    public function published()
    {
        return $this->state(function (array $attributes) {
            return [
                'published_at' => 'suspended',
            ];
        });
    }
}
