<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DatesController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RoomsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\RegisterController;
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
Route::view('/RequestNew', 'RequestNew');
Route::post('/RequestNew', [RequestsController::class, 'insert']);

//Login
Route::view('/Login', 'Login');
Route::view('/login', 'Login');
Route::post('/LoginLogic', [LoginController::class, 'login']);
Route::get('/Logout', [LoginController::class, 'logout']);
Route::get('/logout', [LoginController::class, 'logout']);

//Requests view data: New, Approved and Rejected
Route::get('/Requests/New/{currentPage}', [RequestsController::class, 'new']);
Route::get('/Requests/Approved/{currentPage}', [RequestsController::class, 'approved']);
Route::get('/Requests/Rejected/{currentPage}', [RequestsController::class, 'rejected']);

//Request view image
Route::get('/Requests/Image/{requestID}', [RequestsController::class, 'image']);

//Request change status
Route::get('/Requests/ChangeStatus/{requestID}/{requestStatus}', [RequestsController::class, 'changeStatus']);

//Request excel export
Route::get('/Requests/ExcelExportAll/{statusType}', [RequestsController::class, 'excelExportAll']);
Route::get('/Requests/ExcelExport/{statusType}/{currentPage}', [RequestsController::class, 'excelExport']);

//Manage available dates
Route::get('/Manage/Dates/{currentPage}', [DatesController::class, 'page']);
Route::post('/Manage/DateInsert', [DatesController::class, 'insert']);
Route::post('/Manage/DateDelete', [DatesController::class, 'delete']);

//Manage available rooms
Route::get('/Manage/Rooms/{currentPage}', [RoomsController::class, 'page']);
Route::post('/Manage/RoomInsert', [RoomsController::class, 'insert']);
Route::post('/Manage/RoomUpdate', [RoomsController::class, 'update']);
Route::post('/Manage/RoomDelete', [RoomsController::class, 'delete']);

//Manage available users
Route::get('/Manage/Users/{currentPage}', [UsersController::class, 'page']);
Route::post('/Manage/UserInsert', [UsersController::class, 'insert']);
Route::post('/Manage/UserUpdate', [UsersController::class, 'update']);
Route::post('/Manage/UserDelete', [UsersController::class, 'delete']);

//Request check status (as student)
Route::view('/VerifyRequest', 'VerifyRequest');
Route::post('/VerifyRequest', [RequestsController::class, 'checkStatus']);
Route::post('/Register', [RegisterController::class, 'chooseDate']);

//Examples
// Route::get('/SomeRoute', function () {
//     some logic
//
//     return view(
//         'SomeView'
//     );
// });
