<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class Requests
{
    public static function newAll()
    {
        $result = DB::table('requests')
            ->where('requestStatus', 0)
            ->orderBy('requestID')
            ->select(array(
                'requestID',
                'fullName', 'idOfTest', 'faculty',
                'speciality', 'course', 'department', 'subject',
                'mail', 'phoneNumber', 'reason', 'requestStatus'
            ))
            ->get();

        return $result;
    }

    public static function newPage(int $perPage, int $currentPage)
    {
        $offSet = $currentPage * $perPage;

        $result = DB::table('requests')
            ->where('requestStatus', 0)
            ->orderBy('requestID')
            ->limit($perPage)
            ->offset($offSet)
            ->select(array(
                'requestID',
                'fullName', 'idOfTest', 'faculty',
                'speciality', 'course', 'department', 'subject',
                'mail', 'phoneNumber', 'reason', 'requestStatus'
            ))
            ->get();

        return $result;
    }

    public static function approvedAll()
    {
        $result = DB::table('requests')
            ->where('requestStatus', 1)
            ->orWhere('requestStatus', 2)
            ->orderBy('requestID')
            ->select(array(
                'requestID',
                'fullName', 'idOfTest', 'faculty',
                'speciality', 'course', 'department', 'subject',
                'mail', 'phoneNumber', 'reason', 'requestStatus'
            ))
            ->get();

        return $result;
    }

    public static function approvedPage(int $perPage, int $currentPage)
    {
        $offSet = $currentPage * $perPage;

        $result = DB::table('requests')
            ->where('requestStatus', 1)
            ->orWhere('requestStatus', 2)
            ->orderBy('requestID')
            ->limit($perPage)
            ->offset($offSet)
            ->select(array(
                'requestID',
                'fullName', 'idOfTest', 'faculty',
                'speciality', 'course', 'department', 'subject',
                'mail', 'phoneNumber', 'reason', 'requestStatus'
            ))
            ->get();

        return $result;
    }

    public static function rejectedAll()
    {
        $result = DB::table('requests')
            ->where('requestStatus', 3)
            ->orderBy('requestID')
            ->select(array(
                'requestID',
                'fullName', 'idOfTest', 'faculty',
                'speciality', 'course', 'department', 'subject',
                'mail', 'phoneNumber', 'reason', 'requestStatus'
            ))
            ->get();

        return $result;
    }

    public static function rejectedPage(int $perPage, int $currentPage)
    {
        $offSet = $currentPage * $perPage;

        $result = DB::table('requests')
            ->where('requestStatus', 3)
            ->orderBy('requestID')
            ->limit($perPage)
            ->offset($offSet)
            ->select(array(
                'requestID',
                'fullName', 'idOfTest', 'faculty',
                'speciality', 'course', 'department', 'subject',
                'mail', 'phoneNumber', 'reason', 'requestStatus'
            ))
            ->get();

        return $result;
    }

    public static function insert($data)
    {
        DB::table('requests')->insert($data);
    }

    public static function updateTo(int $requestID, string $requestStatus)
    {
        $databaseRequestStatus = DB::table('requests')
            ->where('requestID', $requestID)
            ->select('requestStatus')
            ->first();

        if ($databaseRequestStatus->requestStatus == 2) {
            return redirect('/Index?error=Нельзя изменить статус заявки, так как студент уже выбрал дату пересдачи');
        }

        DB::table('requests')
            ->where('requestID', $requestID)
            ->update(['requestStatus' => $requestStatus]);
    }

    public static function updateToChosen(int $requestID)
    {
        DB::table('requests')
            ->where('requestID', $requestID)
            ->update(['requestStatus' => 2]);
    }

    public static function image(int $requestID)
    {
        $image = DB::table('requests')
            ->where('requestID', $requestID)
            ->select('confirmationFile')
            ->first();

        return $image;
    }

    public static function requestIDMailStatus(int $requestID)
    {
        $requestData = DB::table('requests')
            ->where('requestID', $requestID)
            ->select(array(
                'requestID', 'mail', 'requestStatus'
            ))
            ->first();

        return $requestData;
    }
}
