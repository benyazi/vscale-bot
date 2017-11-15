<?php

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
use Telegram\Bot\Laravel\Facades\Telegram;

Route::get('/', '\App\Http\Controllers\TelegramController@getHello');
Route::get('/updates', '\App\Http\Controllers\TelegramController@getUpdate');
Route::post('/telegram/webhook', function () {
    $update = Telegram::commandsHandler(true);
    // Commands handler method returns an Update object.
    // So you can further process $update object
    // to however you want.
    return 'ok';
});
Auth::routes();

Route::get('/home', 'HomeController@index');
