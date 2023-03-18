<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\LoginController;

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
Route::get('/Index', function () {
    return view(
        'Index'
    );
});
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
Route::post('/NewRequest', [BookingController::class, 'insert']);

//Login
Route::get('/Login', function () {
    return view(
        'Login'
    );
});
Route::get('/login', function () {
    return view(
        'Login'
    );
});
Route::post('/LoginLogic', [LoginController::class, 'login']);
Route::get('/Logout', [LoginController::class, 'Logout']);
Route::get('/logout', [LoginController::class, 'Logout']);

//Login
Route::get('/Login', function () {
    return view(
        'requests',
        [RequestsController::class, 'new']
    );
});

//Checking request status
Route::get('/VerifyRequest', function () {
    return view(
        'VerifyRequest'
    );
});
