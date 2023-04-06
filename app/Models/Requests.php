<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class Requests
{
    public static function one(int $requestID)
    {
        $result = DB::table('requests')
            ->where('requestID', $requestID)
            ->select(array(
                'requestID', 'fullName', 'idOfTest', 'faculty',
                'speciality', 'course', 'department', 'subject',
                'mail', 'phoneNumber', 'reason', 'examType'
            ))
            ->first();

        return $result;
    }

    private static function whereRequestStatus($statusType)
    {
        $whereRequestStatus = function ($query) use ($statusType) {
            switch ($statusType) {
                case 'new':
                    return $query
                        ->where('requestStatus', 0);
                case 'approved':
                    return $query
                        ->where('requestStatus', 1)
                        ->orWhere('requestStatus', 2);
                case 'rejected':
                    return $query
                        ->where('requestStatus', 3);
            }
        };

        return $whereRequestStatus;
    }

    public static function all($statusType, int $currentExamSessionID)
    {
        $result = DB::table('requests')
            ->where(Requests::whereRequestStatus($statusType))
            ->where('examSessionID', $currentExamSessionID)
            ->orderByDesc('requestID')
            ->select(array(
                'requestID', 'fullName', 'idOfTest', 'faculty',
                'speciality', 'course', 'department', 'subject',
                'mail', 'phoneNumber', 'reason', 'examType'
            ))
            ->get();

        return $result;
    }

    public static function page($statusType, int $perPage, int $currentPage, int $currentExamSessionID)
    {
        $offSet = $currentPage * $perPage;

        $result = DB::table('requests')
            ->where(Requests::whereRequestStatus($statusType))
            ->where('examSessionID', $currentExamSessionID)
            ->orderByDesc('requestID')
            ->limit($perPage)
            ->offset($offSet)
            ->select(array(
                'requestID', 'fullName', 'idOfTest', 'faculty',
                'speciality', 'course', 'department', 'subject',
                'mail', 'phoneNumber', 'reason',  'examType'
            ))
            ->get();

        return $result;
    }

    public static function search($statusType, $searchRequest, $searchType, int $currentExamSessionID)
    {
        $result = DB::table('requests')
            ->where(Requests::whereRequestStatus($statusType))
            ->where('examSessionID', $currentExamSessionID)
            ->where("{$searchType}", 'like', "%{$searchRequest}%")
            ->orderByDesc('requestID')
            ->select(array(
                'requestID', 'fullName', 'idOfTest', 'faculty',
                'speciality', 'course', 'department', 'subject',
                'mail', 'phoneNumber', 'reason',  'examType'
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
        DB::table('requests')
            ->where('requestID', $requestID)
            ->update(['requestStatus' => $requestStatus]);
    }

    public static function requestStatus(int $requestID)
    {
        $requestStatus = DB::table('requests')
            ->where('requestID', $requestID)
            ->select('requestStatus')
            ->first();

        return $requestStatus;
    }

    public static function image(int $requestID)
    {
        $image = DB::table('requests')
            ->where('requestID', $requestID)
            ->select('confirmationFile')
            ->first();

        return $image;
    }

    public static function requestCheck(int $requestID)
    {
        $requestData = DB::table('requests')
            ->where('requestID', $requestID)
            ->select(array(
                'requestID', 'mail', 'requestStatus', 'examSessionID'
            ))
            ->first();

        return $requestData;
    }

    public static function count($examSessionID)
    {
        $requestsAmount = DB::table('requests')
            ->where('examSessionID', $examSessionID)
            ->count();

        return $requestsAmount;
    }
}
