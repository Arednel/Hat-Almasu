<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class ExamSessions
{
    public static function all()
    {
        $result = DB::table('examsessions')->get();

        return $result;
    }

    public static function get($sessionID)
    {
        $result = DB::table('examsessions')
            ->where('examsessions', $sessionID)
            ->first();

        return $result;
    }

    public static function page(int $perPage, int $currentPage)
    {
        $offSet = $currentPage * $perPage;

        $result = DB::table('examsessions')
            ->limit($perPage)
            ->offset($offSet)
            ->get();

        return $result;
    }

    public static function insert()
    {
        DB::table('examsessions')->insert(array('examSessionID' => null));
    }

    public static function delete($sessionID)
    {
        DB::table('examsessions')
            ->where('examSessionID', $sessionID)
            ->delete();
    }
}
