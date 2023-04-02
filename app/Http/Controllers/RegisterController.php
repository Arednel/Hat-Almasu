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
            if (SiteSettings::currentExamSessionID() != $requestData->examSessionID) {
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

        $availabledates = Dates::allFromTommorow(SiteSettings::currentExamSessionID());

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
        $isOnline = Dates::isOnline($requestDataFromUser->chosenDate);

        if ($isOnline->isOnline) {
            return $isOnline;
        } else {
            $rooms = Rooms::all(SiteSettings::currentExamSessionID());

            $html = '';
            foreach ($rooms as $room) {
                $html .= '<option value="' . $room->roomID . '">' . $room->roomName . '</option>';
            }

            return $html;
        }
    }

    public function chooseHour(Request $requestDataFromUser)
    {
        $hours = Dates::hours($requestDataFromUser->chosenDate);

        $html = '';
        for ($currentHour = $hours->startHour; $currentHour < $hours->endHour; $currentHour++) {

            $bookingRecordsAmount = Booking::bookingRecordsAmount($requestDataFromUser->chosenDate, $requestDataFromUser->roomID, $currentHour);

            $roomSpace = Rooms::roomSpace($requestDataFromUser->roomID);

            $leftSpace = $roomSpace->roomSpace - $bookingRecordsAmount;

            $html .= '<option value="' . $currentHour . '">' . __('C') . ' ' . $currentHour . ':00 ' . __('до') . ' ' .
                ($currentHour + 1) . ':00 (' . __('Осталось') . ' ' .
                $leftSpace . ' ' . __('мест') . ' )</option>';
        }

        return $html;
    }

    public function complete(Request $requestDataFromUser)
    {
        $requestData = $this->requestCheck($requestDataFromUser);

        if ($requestData instanceof \Illuminate\Http\RedirectResponse) {
            return $requestData;
        }

        if ($requestDataFromUser->roomID == 'isOnline') {
            $data = array(
                'bookingdate' => $requestDataFromUser->chosenDate,
                'requestID' => $requestDataFromUser->requestID,
                'isOnline' => true
            );

            Booking::insert($data);
            Requests::updateTo($requestDataFromUser->requestID, 2);

            return redirect('/Index?message=' . __('Вы успешно выбрали дату пересдачи') . ' ' . $requestDataFromUser->chosenDate . ' ' . __('в онлайн формате'));
        } else {
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
            return redirect('/Index?message=' . __('Вы успешно выбрали дату пересдачи') . ' ' . $requestDataFromUser->chosenDate
                . ', ' . __('в аудитории') . ': ' . $roomName->roomName . ', С ' . $requestDataFromUser->startHour . ':00' .
                ' до ' . (($requestDataFromUser->startHour) + 1) . ':00');
        }
    }
}
