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

    public static function newAll(int $currentExamSessionID)
    {
        $result = DB::table('requests')
            ->where('requestStatus', 0)
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

    public static function newPage(int $perPage, int $currentPage, int $currentExamSessionID)
    {
        $offSet = $currentPage * $perPage;

        $result = DB::table('requests')
            ->where('requestStatus', 0)
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

    public static function approvedAll(int $currentExamSessionID)
    {
        $result = DB::table('requests')
            ->where(
                function ($query) {
                    return $query
                        ->where('requestStatus', 1)
                        ->orWhere('requestStatus', 2);
                }
            )
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

    public static function approvedPage(int $perPage, int $currentPage, int $currentExamSessionID)
    {
        $offSet = $currentPage * $perPage;

        $result = DB::table('requests')
            ->where(
                function ($query) {
                    return $query
                        ->where('requestStatus', 1)
                        ->orWhere('requestStatus', 2);
                }
            )
            ->where('examSessionID', $currentExamSessionID)
            ->orderByDesc('requestID')
            ->limit($perPage)
            ->offset($offSet)
            ->select(array(
                'requestID', 'fullName', 'idOfTest', 'faculty',
                'speciality', 'course', 'department', 'subject',
                'mail', 'phoneNumber', 'reason', 'examType'
            ))
            ->get();

        return $result;
    }

    public static function rejectedAll(int $currentExamSessionID)
    {
        $result = DB::table('requests')
            ->where('requestStatus', 3)
            ->where('examSessionID', $currentExamSessionID)
            ->orderByDesc('requestID')
            ->select(array(
                'requestID', 'fullName', 'idOfTest', 'faculty',
                'speciality', 'course', 'department', 'subject',
                'mail', 'phoneNumber', 'reason',  'examType'
            ))
            ->get();

        return $result;
    }

    public static function rejectedPage(int $perPage, int $currentPage, int $currentExamSessionID)
    {
        $offSet = $currentPage * $perPage;

        $result = DB::table('requests')
            ->where('requestStatus', 3)
            ->where('examSessionID', $currentExamSessionID)
            ->orderByDesc('requestID')
            ->limit($perPage)
            ->offset($offSet)
            ->select(array(
                'requestID', 'fullName', 'idOfTest', 'faculty',
                'speciality', 'course', 'department', 'subject',
                'mail', 'phoneNumber', 'reason', 'examType'
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

    public static function count($examSessionID)
    {
        $requestsAmount = DB::table('requests')
            ->where('examSessionID', $examSessionID)
            ->count();

        return $requestsAmount;
    }
}
