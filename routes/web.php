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


Route::get('/test2', function () {
    return view('Audioo');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('AdminRegister',function()
{
    return view("AdminRegister");
} )->name('AdminRegister');

Route::get('/register', 'HomeController@register')->name('register');
Route::get('/register_aliraya', 'HomeController@registerId');
Route::post('/changePassword','HomeController@changePassword')->name('changePassword');
Route::get('/changePassword','HomeController@showpassword')->name('changePassword');
Route::get('/deleteUser/{id}','HomeController@deleteUser');
Route::get('/editUser/{id}','HomeController@edit');
Route::post('/update/{id}','HomeController@update');
Route::get('/reset/{id}','HomeController@rest');
Route::get('/block/{id}','HomeController@block');
Route::get('/porfile','HomeController@profile')->name('profile');
Route::get('/Extension',function(){
    return view('Extension');
})->name('Extension');

Route::get('/deleteaudio/{id}', 'AudioController@destroy');
Route::get('/Audio', 'AudioController@index')->name('Audio');
Route::get('/AddAudio', 'AudioController@indexAdd');
Route::post('/Addaudio', 'AudioController@store')->name('Addaudio');
Route::get('/test-php', 'AudioController@test');

Route::get('/User/useraudio/{id}', 'AudioController@useraudio');



Route::get('User/{id}','HomeController@getuser');
