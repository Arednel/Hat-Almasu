<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class Dates
{
    public static function page(int $perPage, int $currentPage)
    {
        $offSet = $currentPage * $perPage;

        $result = DB::table('availabledates')
            ->limit($perPage)
            ->offset($offSet)
            ->get();

        return $result;
    }

    public static function insert($data)
    {
        DB::table('availabledates')->insert($data);
    }

    public static function delete($date)
    {
        DB::table('availabledates')
            ->where('date', $date)
            ->delete();
    }

    public static function all()
    {
        $result = DB::table('availabledates')->get();

        return $result;
    }

    public static function allDate()
    {
        $result = DB::table('availabledates')
            ->select('date')
            ->get();

        return $result;
    }

    public static function isOnline($date)
    {
        $result = DB::table('availabledates')
            ->where('date', $date)
            ->select('isOnline')
            ->first();

        return $result;
    }
}
