<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RequestsController;

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
Route::view('/', 'Index');
Route::view('/index', 'Index');
Route::view('/Index', 'Index');

//Info about version and author
Route::view('/Info', 'Info');
Route::view('/info', 'Info');

//Creating new request
Route::view('/Booking', 'Booking');
Route::post('/NewRequest', [BookingController::class, 'insert']);

//Login
Route::view('/Login', 'Login');
Route::view('/login', 'Login');
Route::post('/LoginLogic', [LoginController::class, 'login']);
Route::get('/Logout', [LoginController::class, 'Logout']);
Route::get('/logout', [LoginController::class, 'Logout']);

//Requests view: New, Approved and Rejected requests
Route::get('/Requests/New', [RequestsController::class, 'new']);
Route::get('/Requests/Approved', [RequestsController::class, 'approved']);
Route::get('/Requests/Rejected', [RequestsController::class, 'rejected']);

//Checking request status
Route::view('/VerifyRequest', 'VerifyRequest');

//Examples
// Route::get('/SomeRoute', function () {
//     some logic
//
//     return view(
//         'SomeView'
//     );
// });
