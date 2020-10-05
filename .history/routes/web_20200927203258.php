<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConcertController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('bla', [ConcertController::class, 'bla']);
Route::get('concert/{id}', [ConcertController::class, 'show']);
