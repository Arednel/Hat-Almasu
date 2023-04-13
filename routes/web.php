<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cookie;

use Illuminate\Support\Facades\Session;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DatesController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RoomsController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RequestsController;
use App\Http\Controllers\OccupancyController;
use App\Http\Controllers\ExamSessionsController;

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
Route::view('/', 'Index')->name('index');
Route::view('/index', 'Index');
Route::view('/Index', 'Index');

//Info about version and author
Route::view('/Info', 'Info');
Route::view('/info', 'Info');

//Creating new request
Route::get('/RequestNew', [RequestsController::class, 'sendNew']);
Route::post('/RequestNew', [RequestsController::class, 'insert']);

//Login
Route::view('/Login', 'Login');
Route::view('/login', 'Login');
Route::post('/LoginLogic', [LoginController::class, 'login']);
Route::get('/Logout', [LoginController::class, 'logout']);
Route::get('/logout', [LoginController::class, 'logout']);

//Requests view (new, approved and rejected)
Route::get('/Requests/View/{statusType}/{currentPage}', [RequestsController::class, 'page'])->middleware('auth', 'can:viewer');

//Requests search
Route::get('/Requests/Search', [RequestsController::class, 'search'])->middleware('auth', 'can:viewer');

//Request view image
Route::get('/Requests/Image/{requestID}', [RequestsController::class, 'image'])->middleware('auth', 'can:viewer');

//Request change status
Route::get('/Requests/ChangeStatus/{requestID}/{requestStatus}', [RequestsController::class, 'changeStatus'])->middleware('auth', 'can:support');

//Request excel export
Route::get('/ExcelExportAll/{statusType}', [RequestsController::class, 'excelExportAll'])->middleware('auth', 'can:viewer');
Route::get('/ExcelExport/{statusType}/{currentPage}', [RequestsController::class, 'excelExport'])->middleware('auth', 'can:viewer');

//Manage available dates
Route::get('/Manage/Dates/{currentPage}', [DatesController::class, 'page'])->middleware('auth', 'can:admin');
Route::post('/Manage/DateInsert', [DatesController::class, 'insert'])->middleware('auth', 'can:admin');
Route::post('/Manage/DateDelete', [DatesController::class, 'delete'])->middleware('auth', 'can:admin');

//Manage available rooms
Route::get('/Manage/Rooms/{currentPage}', [RoomsController::class, 'page'])->middleware('auth', 'can:admin');
Route::post('/Manage/RoomInsert', [RoomsController::class, 'insert'])->middleware('auth', 'can:admin');
Route::post('/Manage/RoomUpdate', [RoomsController::class, 'update'])->middleware('auth', 'can:admin');
Route::post('/Manage/RoomDelete', [RoomsController::class, 'delete'])->middleware('auth', 'can:admin');

//Manage available users
Route::get('/Manage/Users/{currentPage}', [userController::class, 'page'])->middleware('auth', 'can:admin');
Route::post('/Manage/UserInsert', [userController::class, 'insert'])->middleware('auth', 'can:admin');
Route::post('/Manage/UserUpdate', [userController::class, 'update'])->middleware('auth', 'can:admin');
Route::post('/Manage/UserDelete', [userController::class, 'delete'])->middleware('auth', 'can:admin');

//Manage sessions (current, start date, end date)
Route::get('/Manage/ExamSessions/{currentPage}', [ExamSessionsController::class, 'page'])->middleware('auth', 'can:admin');
Route::post('/Manage/ExamSessionInsert', [ExamSessionsController::class, 'insert'])->middleware('auth', 'can:admin');
Route::post('/Manage/ExamSessionDelete', [ExamSessionsController::class, 'delete'])->middleware('auth', 'can:admin');
Route::post('/Manage/ExamSessionChangeCurrent', [ExamSessionsController::class, 'changeCurrent'])->middleware('auth', 'can:admin');

//Request check status (as student)
Route::view('/Register', 'Register');
Route::post('/Register/Date', [RegisterController::class, 'chooseDate']);
Route::get('/Register/Room', [RegisterController::class, 'chooseRoom']);
Route::get('/Register/Hour', [RegisterController::class, 'chooseHour']);
Route::post('/Register/Complete', [RegisterController::class, 'complete']);

//Occupancy view
Route::get('/Occupancy/Date', [OccupancyController::class, 'dates'])->middleware('auth', 'can:viewer');
Route::get('/Occupancy/Room', [OccupancyController::class, 'chooseRoom'])->middleware('auth', 'can:viewer');
Route::get('/Occupancy/Hour', [OccupancyController::class, 'chooseHour'])->middleware('auth', 'can:viewer');
Route::post('/Occupancy/View', [OccupancyController::class, 'view'])->middleware('auth', 'can:viewer');

//Change language
Route::get('/Language/{locale}', function (string $locale) {
    if (!in_array($locale, ['ru', 'kz'])) {
        abort(404);
    }

    App::setLocale($locale);
    Session::put('locale', $locale);
    Cookie::queue(Cookie::forever('locale', $locale));

    return redirect()->back();
});
