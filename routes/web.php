<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

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

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/administration', 'AdminController@index')->name('administration')
    ->middleware('role:root.hospital');
Route::get('/news', 'NewsController@index')->name('news');
Route::post('/news/add', 'NewsController@AddNews')->middleware('role:manager.hospital');
Route::get('/news/read/{id}', 'NewsController@readNews')->name('read');


Route::get('department/{department}', 'DoctorController@index');
Route::resource('doctor', 'DoctorController');
Route::post('doctor/{doctor}/image', 'DoctorController@image');

Route::get('/cabinet', 'DoctorController@cabinet')->name('cabinet')->middleware('role:doctor.hospital');
Route::get('/profile', 'TicketController@patientsTickets')->name('profile')->middleware('role:patient.hospital');

Route::post('schedule/{schedule}/store', 'TicketController@store')->middleware('role:patient.hospital');
