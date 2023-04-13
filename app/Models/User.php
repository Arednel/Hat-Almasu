<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

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

    public static function updateUserName($id, $userName)
    {

        DB::table('users')
            ->where('id', $id)
            ->update([
                'userName' => $userName,
                'updated_at' => now()
            ]);
    }

    public static function updatePassword($id, $password)
    {
        DB::table('users')
            ->where('id', $id)
            ->update([
                'password' => $password,
                'updated_at' => now()
            ]);
    }

    public static function updateUserPrivilege($id, $userPrivilege)
    {

        DB::table('users')
            ->where('id', $id)
            ->update([
                'userPrivilege' => $userPrivilege,
                'updated_at' => now()
            ]);
    }

    public static function deleteUser($id)
    {
        DB::table('users')
            ->where('id', $id)
            ->delete();
    }
}
