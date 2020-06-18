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
Route::get('/test', function () {
    return view('test');
});

Route::get('/test1', function () {
    return view('test1');
});
Route::get('/test2', function () {
    return view('test2');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('AdminRegister',function()
{
    return view("AdminRegister");
} )->name('AdminRegister');

Route::get('/register', 'HomeController@register')->name('register');
Route::get('/register_aliraya', 'HomeController@registerId');
Route::get('Audio',function()
{
    return view("Audio");
})->name('Audio');

Route::get('/AudioCutter', 'AudioController@AudioCutter')->name('AudioCutter');
Route::post('/Addaudio', 'AudioController@store')->name('Addaudio');
Route::post('/test-php', 'AudioController@test');
