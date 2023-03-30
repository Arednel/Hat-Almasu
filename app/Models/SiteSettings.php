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

        return $result;
    }

    public static function setCurrentExamSessionID($sessionID)
    {
        DB::table('sitesettings')
            ->select('id', 1)
            ->update(['currentExamSessionID' => $sessionID]);
    }
}
