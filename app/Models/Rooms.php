<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class Rooms
{
    public static function all()
    {
        $result = DB::table('rooms')->get();

        return $result;
    }

    public static function get($roomID)
    {
        $result = DB::table('rooms')
            ->where('roomID', $roomID)
            ->first();

        return $result;
    }

    public static function page(int $perPage, int $currentPage)
    {
        $offSet = $currentPage * $perPage;

        $result = DB::table('rooms')
            ->limit($perPage)
            ->offset($offSet)
            ->get();

        return $result;
    }

    public static function insert($data)
    {
        DB::table('rooms')->insert($data);
    }

    public static function updateRoomName($roomID, $roomName)
    {
        DB::table('rooms')
            ->where('roomID', $roomID)
            ->update(['roomName' => $roomName]);
    }

    public static function updateRoomSpace($roomID, $roomSpace)
    {
        DB::table('rooms')
            ->where('roomID', $roomID)
            ->update(['roomSpace' => $roomSpace]);
    }

    public static function delete($roomID)
    {
        DB::table('rooms')
            ->where('roomID', $roomID)
            ->delete();
    }
}
