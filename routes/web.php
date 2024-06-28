<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

use TCG\Voyager\Facades\Voyager;

use App\Http\Controllers\SupportTicketsController;

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

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

//Requests
Route::controller(SupportTicketsController::class)->group(function () {
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

//Change language
Route::get('/Language/{locale}', function (string $locale) {
    App::setLocale($locale);
    Session::put('locale', $locale);
    Cookie::queue(Cookie::forever('locale', $locale));

    return redirect()->back();
})->whereIn('locale', ['ru', 'kz']);
