<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class SiteSettings
{
    public static function currentExamSessionID()
    {
        $result = DB::table('sitesettings')
            ->select('currentExamSessionID')
            ->first();

        return $result->currentExamSessionID;
    }

    public static function setCurrentExamSessionID($examSessionID)
    {
        DB::table('sitesettings')
            ->select('id', 1)
            ->update(['currentExamSessionID' => $examSessionID]);
    }

    public static function canSendRequests()
    {
        $result = DB::table('sitesettings')
            ->select('canSendRequests')
            ->first();

        return $result->canSendRequests;
    }
}
