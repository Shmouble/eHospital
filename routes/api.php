<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('doctor/{doctor}/schedule', 'ScheduleController');

Route::get('doctor/{doctor}/numberoffreetickets', 'TicketController@numberOfFreeTickets');
//Route::group(['middleware' => 'auth:api'], function(){
Route::get('schedule/{schedule}/doctorstickets', 'TicketController@doctorsTickets');
Route::get('schedule/{schedule}/freetickets', 'TicketController@freeTickets');
Route::post('schedule/{schedule}/store', 'TicketController@store');
Route::delete('/ticket/{ticket}', 'TicketController@destroy');
//});

