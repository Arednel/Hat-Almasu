<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class Sessions
{
    public static function all()
    {
        $result = DB::table('sessions')->get();

        return $result;
    }

    public static function get($sessionID)
    {
        $result = DB::table('sessions')
            ->where('sessions', $sessionID)
            ->first();

        return $result;
    }

    public static function page(int $perPage, int $currentPage)
    {
        $offSet = $currentPage * $perPage;

        $result = DB::table('sessions')
            ->limit($perPage)
            ->offset($offSet)
            ->get();

        return $result;
    }

    public static function insert($data)
    {
        DB::table('sessions')->insert($data);
    }

    public static function delete($sessionID)
    {
        DB::table('sessions')
            ->where('sessionID', $sessionID)
            ->delete();
    }
}
