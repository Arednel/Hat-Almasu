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

//Info page about site
Route::view('/Info', 'Info');
Route::view('/info', 'Info');

//Request check status and register (as student)
Route::controller(RegisterController::class)->group(function () {
    Route::view('/Register', 'Register');
    Route::post('/Register/Date', 'chooseDate');
    Route::get('/Register/Room', 'chooseRoom');
    Route::get('/Register/Hour', 'chooseHour');
    Route::post('/Register/Complete', 'complete');
});

//Login
Route::view('/Login', 'Login');
Route::view('/login', 'Login');
Route::post('/LoginLogic', [LoginController::class, 'login']);
Route::get('/Logout', [LoginController::class, 'logout']);
Route::get('/logout', [LoginController::class, 'logout']);

//Requests
Route::controller(RequestsController::class)->group(function () {
    //Creating new request (as student)
    Route::get('/RequestNew', 'sendNew');
    Route::post('/RequestNew', 'insert');

    //Requests managing
    Route::middleware(['auth', 'can:viewer'])->group(function () {
        //Requests view (new, approved and rejected)
        Route::get('/Requests/View/{statusType}/{currentPage}',  'page')
            ->whereIn('statusType', ['new', 'approved', 'rejected'])
            ->whereNumber('currentPage');

        //Requests search
        Route::get('/Requests/Search', 'search');

        //Request view image
        Route::get('/Requests/Image/{requestID}', 'image')
            ->whereNumber('requestID');

        //Request change status (support and up only)
        Route::get('/Requests/ChangeStatus/{requestID}/{requestStatus}',  'changeStatus')->middleware('auth', 'can:support')
            ->whereNumber('requestID')
            ->whereIn('requestStatus', ['1', '3']);

        //Request excel export
        Route::get('/ExcelExportAll/{statusType}', 'excelExportAll')
            ->whereIn('statusType', ['new', 'approved', 'rejected']);
        Route::get('/ExcelExport/{statusType}/{currentPage}',  'excelExport')
            ->whereIn('statusType', ['new', 'approved', 'rejected'])
            ->whereNumber('currentPage');
    });
});

//Occupancy view
Route::group(['controller' => OccupancyController::class, 'middleware' => ['auth', 'can:viewer']], function () {
    Route::get('/Occupancy/Date', 'dates');
    Route::get('/Occupancy/Room', 'chooseRoom');
    Route::get('/Occupancy/Hour', 'chooseHour');
    Route::post('/Occupancy/View', 'view');
});

//Admin Only managing
Route::group(['middleware' => ['auth', 'can:admin']], function () {
    //Manage available dates
    Route::controller(DatesController::class)->group(function () {
        Route::get('/Manage/Dates/{currentPage}', 'page')
            ->whereNumber('currentPage');
        Route::post('/Manage/DateInsert', 'insert');
        Route::post('/Manage/DateDelete', 'delete');
    });

    //Manage available rooms
    Route::controller(RoomsController::class)->group(function () {
        Route::get('/Manage/Rooms/{currentPage}', 'page')
            ->whereNumber('currentPage');
        Route::post('/Manage/RoomInsert', 'insert');
        Route::post('/Manage/RoomUpdate', 'update');
        Route::post('/Manage/RoomDelete', 'delete');
    });

    //Manage available users
    Route::controller(UserController::class)->group(function () {
        Route::get('/Manage/Users/{currentPage}', 'page')
            ->whereNumber('currentPage');
        Route::post('/Manage/UserInsert', 'insert');
        Route::post('/Manage/UserUpdate', 'update');
        Route::post('/Manage/UserDelete', 'delete');
    });

    //Manage sessions (current, start date, end date)
    Route::controller(ExamSessionsController::class)->group(function () {
        Route::get('/Manage/ExamSessions/{currentPage}', 'page')
            ->whereNumber('currentPage');
        Route::post('/Manage/ExamSessionInsert', 'insert');
        Route::post('/Manage/ExamSessionDelete', 'delete');
        Route::post('/Manage/ExamSessionChangeCurrent', 'changeCurrent');
    });
});

//Change language
Route::get('/Language/{locale}', function (string $locale) {
    App::setLocale($locale);
    Session::put('locale', $locale);
    Cookie::queue(Cookie::forever('locale', $locale));

    return redirect()->back();
})->whereIn('locale', ['ru', 'kz']);
