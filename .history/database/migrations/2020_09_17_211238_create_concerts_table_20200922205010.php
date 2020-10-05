<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConcertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('concerts', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('subtitle');
            $table->datetime('date');
            $table->string('price');
            $table->string('adresse');
            $table->string('city');
            $table->string('zip');

            $table->title'    => 'Title',
            'subtitle' => 'subtitle',
            'date'     => Carbon::parse('15/02/2021 09:00'),
            'price'    => 4000,
            'adresse'  => 'Royal theatre',
            'City'     => 'Marrakesh',
            'zip'      => '40000',

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('concerts');
    }
}
