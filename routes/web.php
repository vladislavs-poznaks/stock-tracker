<?php

use App\Models\Stock;
use App\Models\User;
use App\Notifications\ImportantStockUpdate;
use Illuminate\Support\Facades\Route;

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

Route::get('/mail-preview', function () {
    return (new ImportantStockUpdate(Stock::first()))->toMail(User::factory()->create());
});

Route::get('/', function () {
    return view('welcome');
});
