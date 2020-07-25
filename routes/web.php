<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/administration', 'AdminController@index')->name('administration')
    ->middleware('role:root.hospital');
Route::get('/news', 'NewsController@index')->name('news');
Route::post('/news/add', 'NewsController@AddNews');

Route::get('department/{department}', 'DoctorController@index');
Route::resource('doctor', 'DoctorController');
Route::post('doctor/{doctor}/image', 'DoctorController@image');
Route::get('/cabinet', 'DoctorController@cabinet');


