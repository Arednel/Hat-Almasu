<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class SiteSettings
{
    public static function currentSessionID()
    {
        $result = DB::table('sitesettings')
            ->select('currentSessionID')
            ->first();

        return $result;
    }

    public static function setCurrentSession($sessionID)
    {
        DB::table('sitesettings')
            ->select('id', 1)
            ->update(['currentSessionID' => $sessionID]);
    }
}
