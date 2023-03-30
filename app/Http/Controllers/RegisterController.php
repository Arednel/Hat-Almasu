<?php

namespace App\Http\Controllers;

use App\Models\Dates;
use App\Models\Rooms;
use App\Models\Booking;
use App\Models\Requests;
use App\Models\SiteSettings;

use Illuminate\Http\Request;

class RegisterController extends Controller
{
    private function requestCheck($requestDataFromUser)
    {
        $requestDataFromUser->validate(
            [
                'mail' => ['required', 'email'],
                'requestID' => 'required'
            ]
        );

        $requestData = Requests::requestCheck($requestDataFromUser->requestID);

        if ($requestData == null) {
            return redirect('/Index?error=Заявки не существует');
        }

        if (
            $requestData->requestID == $requestDataFromUser->requestID
            &&
            $requestData->mail == $requestDataFromUser->mail
        ) {
            $currentExamSessionID = SiteSettings::currentExamSessionID()->currentExamSessionID;
            if ($currentExamSessionID != $requestData->examSessionID) {
                return redirect('/Index?error=Заявка была отправлена во время другой сессии');
            }

            switch ($requestData->requestStatus) {
                case 0:
                    return redirect('/Index?messageokay=Заявка рассматривается');
                case 1:
                    return $requestData;
                case 2:
                    return redirect('/Index?messageokay=Вы уже выбрали время');
                case 3:
                    return redirect('/Index?messageokay=Заявка была отклонена');
            }
        } else {
            return redirect('/Index?error=Указаны неверные данные');
        }
    }

    public function chooseDate(Request $requestDataFromUser)
    {
        $requestData = $this->requestCheck($requestDataFromUser);

        if ($requestData instanceof \Illuminate\Http\RedirectResponse) {
            return $requestData;
        }

        $availabledates = Dates::allFromTommorow();

        if ($availabledates->isEmpty()) {
            return redirect('/Index?error=Нет доступных дат для пересдачи');
        }

        return view('Register', [
            'requestID' => $requestData->requestID, 'mail' => $requestData->mail,
            'availabledates' => $availabledates
        ]);
    }

    public function chooseRoom(Request $requestDataFromUser)
    {
        $requestData = $this->requestCheck($requestDataFromUser);

        if ($requestData instanceof \Illuminate\Http\RedirectResponse) {
            return $requestData;
        }

        $isOnline = Dates::isOnline($requestDataFromUser->date);

        if ($isOnline->isOnline) {
            $data = array(
                'bookingdate' => $requestDataFromUser->date,
                'requestID' => $requestDataFromUser->requestID,
                'isOnline' => true
            );

            Booking::insert($data);
            Requests::updateTo($requestDataFromUser->requestID, 2);

            return redirect('/Index?message=Вы успешно выбрали дату пересдачи');
        } else {
            $rooms = Rooms::all();

            return view('Register', [
                'requestID' => $requestDataFromUser->requestID, 'mail' => $requestDataFromUser->mail,
                'chosenDate' => $requestDataFromUser->date, 'rooms' => $rooms
            ]);
        }
    }

    public function chooseHour(Request $requestDataFromUser)
    {
        $requestData = $this->requestCheck($requestDataFromUser);

        if ($requestData instanceof \Illuminate\Http\RedirectResponse) {
            return $requestData;
        }

        $hours = Dates::hours($requestDataFromUser->chosenDate);

        $amountOfHours = $hours->endHour - $hours->startHour;

        return view('Register', [
            'requestID' => $requestDataFromUser->requestID, 'mail' => $requestDataFromUser->mail,
            'chosenDate' => $requestDataFromUser->chosenDate, 'roomID' =>  $requestDataFromUser->roomID,
            'startHour' =>  $hours->startHour, 'hours' =>  $amountOfHours
        ]);
    }

    public function complete(Request $requestDataFromUser)
    {
        $requestData = $this->requestCheck($requestDataFromUser);

        if ($requestData instanceof \Illuminate\Http\RedirectResponse) {
            return $requestData;
        }

        $data = array(
            'bookingdate' => $requestDataFromUser->chosenDate,
            'requestID' => $requestDataFromUser->requestID,
            'isOnline' => false,
            'startHour' => $requestDataFromUser->startHour,
            'roomID' => $requestDataFromUser->roomID,
        );

        Booking::insert($data);
        Requests::updateTo($requestDataFromUser->requestID, 2);

        $roomName = Rooms::get($requestDataFromUser->roomID);
        return redirect('/Index?message=Вы успешно выбрали время пересдачи ' . $requestDataFromUser->chosenDate
            . ', в аудитории: ' . $roomName->roomName . ', С ' . $requestDataFromUser->startHour . ':00' .
            ' до ' . (($requestDataFromUser->startHour) + 1) . ':00');
    }
}
