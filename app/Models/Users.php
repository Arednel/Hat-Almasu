<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class Users
{
    public static function page(int $perPage, int $currentPage)
    {
        $offSet = $currentPage * $perPage;

        $result = DB::table('users')
            ->limit($perPage)
            ->offset($offSet)
            ->get();

        return $result;
    }
    public static function insert($data)
    {
        DB::table('users')->insert($data);
    }

    public static function updateUserName($userID, $userName)
    {

        DB::table('users')
            ->where('userID', $userID)
            ->update(['userName' => $userName], ['updated_at' => time()]);
    }

    public static function updateUserPassword($userID, $userPassword)
    {

        DB::table('users')
            ->where('userID', $userID)
            ->update(['userPassword' => $userPassword], ['updated_at' => time()]);
    }

    public static function updateUserPrivilege($userID, $userPrivilege)
    {

        DB::table('users')
            ->where('userID', $userID)
            ->update(['userPrivilege' => $userPrivilege], ['updated_at' => time()]);
    }

    public static function delete($userID)
    {
        DB::table('users')
            ->where('userID', $userID)
            ->delete();
    }
}
