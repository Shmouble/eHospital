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

Route::get('/', function () {
    return view('welcome');
});

Route::get('hello', function () {
    return view ('hello', ['name' => 'User']);
});

Route::get('hospitalslist', function () {
    return view('hospitalslist');
});

Route::get('hospital1', function () {
    return view('hospital1');
});

Route::get('hospital2', function () {
    return view('hospital2');
});

Route::get('hospital3', function () {
    return view('hospital3');
});


