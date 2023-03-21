<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class Booking
{
    public static function insert($data)
    {
        DB::table('bookingrecords')->insert($data);
    }
}
