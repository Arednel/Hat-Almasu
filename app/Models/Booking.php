<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class Booking
{
    public static function insert($data)
    {
        DB::table('bookingrecords')->insert($data);
    }

    public static function selectWhereOnline($bookingDate)
    {
        $result = DB::table('bookingrecords')
            ->where('bookingdate', $bookingDate)
            ->select('requestID')
            ->get();

        return $result;
    }

    public static function selectWhereOffline($bookingDate, int $startHour, int $roomID)
    {
        $result = DB::table('bookingrecords')
            ->where('bookingdate', $bookingDate)
            ->where('startHour', $startHour)
            ->where('roomID', $roomID)
            ->select('requestID')
            ->get();

        return $result;
    }
}
