<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

use App\Http\Controllers\DatesController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RoomsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RequestsController;
use App\Http\Controllers\ExamSessionsController;
use App\Http\Controllers\OccupancyController;

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

//Manage sessions (current, start date, end date)
Route::get('/Manage/ExamSessions/{currentPage}', [ExamSessionsController::class, 'page']);
Route::post('/Manage/ExamSessionInsert', [ExamSessionsController::class, 'insert']);
Route::post('/Manage/ExamSessionDelete', [ExamSessionsController::class, 'delete']);
Route::post('/Manage/ExamSessionChangeCurrent', [ExamSessionsController::class, 'changeCurrent']);

//Request check status (as student)
Route::view('/Register', 'Register');
Route::post('/Register/Date', [RegisterController::class, 'chooseDate']);
Route::post('/Register/Room', [RegisterController::class, 'chooseRoom']);
Route::post('/Register/Hour', [RegisterController::class, 'chooseHour']);
Route::post('/Register/Complete', [RegisterController::class, 'complete']);

//Occupancy view
Route::get('/Occupancy/Date', [OccupancyController::class, 'chooseDate']);
Route::post('/Occupancy/Room', [OccupancyController::class, 'chooseRoom']);
Route::post('/Occupancy/Hour', [OccupancyController::class, 'chooseHour']);
Route::post('/Occupancy/View', [OccupancyController::class, 'view']);

//Change language
Route::get('/Language/{locale}', function (string $locale) {
    if (!in_array($locale, ['ru', 'kz'])) {
        abort(404);
    }

    App::setLocale($locale);
    Session::put('locale', $locale);

    return redirect()->back();
});
