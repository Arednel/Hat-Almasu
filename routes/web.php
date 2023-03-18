<?php

use App\Models\Posts;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;

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

//Main Page
Route::get('/', function () {
    return view(
        'Index'
    );
});
//Main Page
Route::get('/Index', function () {
    return view(
        'Index'
    );
});
//Main Page
Route::get('/index', function () {
    return view(
        'Index'
    );
});

//Info about version and author
Route::get('/Info', function () {
    return view(
        'Info'
    );
});

//Creating new request
Route::get('/Booking', function () {
    return view(
        'Booking'
    );
});
//Creating new request
Route::post('/NewRequest', [BookingController::class, 'insert']);

//
Route::get('/Login', function () {
    return view(
        'Login'
    );
});

//Checking request status
Route::get('/VerifyRequest', function () {
    return view(
        'VerifyRequest'
    );
});
