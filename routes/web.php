<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

use TCG\Voyager\Facades\Voyager;

use App\Http\Controllers\SupportTicketController;

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

    //Choose tickets by status (should be before voyager routes)
    Route::get('/supporttickets/{status}', [SupportTicketController::class, 'chooseByStatus']);

    Voyager::routes();

    Route::middleware(['admin.user'])->group(function () {
        //Redirect to support tickets by default
        Route::redirect('/', '/admin/supporttickets');


        //Approve Support Ticket
        Route::get('supportticket/approve/{support_ticket_id}', [SupportTicketController::class, 'approveSupportTicket'])
            ->name('approve_support_ticket');
        //Reject Support Ticket
        Route::get('supportticket/reject/{support_ticket_id}', [SupportTicketController::class, 'rejectSupportTicket'])
            ->name('reject_support_ticket');
    });
});
//Requests
Route::controller(SupportTicketController::class)->group(function () {
    //Creating new request (for student student)
    Route::get('/SupportTicketNew', 'sendNew');
    Route::post('/SupportTicketNew', 'insert');

    //Requests managing
    //Route::middleware(['auth', 'can:support'])->group(function () {
    //Request excel export
    // Route::get('/ExcelExportAll/{statusType}', 'excelExportAll')
    //     ->whereIn('statusType', ['new', 'approved', 'rejected']);
    // Route::get('/ExcelExport/{statusType}/{currentPage}',  'excelExport')
    //     ->whereIn('statusType', ['new', 'approved', 'rejected'])
    //     ->whereNumber('currentPage');
    // });
});

Route::get('/SupportTicketStatus', [SupportTicketController::class, 'supportTicketStatusCookie']);
Route::post('/SupportTicketStatus', [SupportTicketController::class, 'supportTicketStatus']);

//Change language
Route::get('/Language/{locale}', function (string $locale) {
    App::setLocale($locale);
    Session::put('locale', $locale);
    Cookie::queue(Cookie::forever('locale', $locale));

    return redirect()->back();
})->whereIn('locale', ['ru', 'kz']);
