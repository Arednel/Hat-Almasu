<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\SoftDeletes;

use TCG\Voyager\Http\Controllers\VoyagerBaseController;

use Carbon\Carbon;

use App\Models\SiteSettings;
use App\Models\SupportTicket;

use TCG\Voyager\Facades\Voyager;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

use App\Exports\SupportTicketsExport;

class DormitoryTicket extends VoyagerBaseController
{
    public function sendNew()
    {
        $canSendSupportTickets = SiteSettings::canSendRequests();
        if (!$canSendSupportTickets) {
            return redirect('/Index?error=Сейчас нельзя подавать новые заявки');
        }

        return view('DormitoryTicketNew');
    }

    public function inProgress(Request $request)
    {
        return redirect('Index?message=В разработке');
    }
}
