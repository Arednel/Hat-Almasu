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
    private function requestCheck($request)
    {
        $request->validate(
            [
                'mail' => ['required', 'email'],
                'requestID' => 'required'
            ]
        );

        $requestData = Requests::requestCheck($request->requestID);

        if ($requestData == null) {
            return redirect('/Index?error=Заявки не существует');
        }

        if (
            $requestData->requestID == $request->requestID
            &&
            $requestData->mail == $request->mail
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

    public function chooseDate(Request $request)
    {
        $requestData = $this->requestCheck($request);

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

    public function chooseRoom(Request $request)
    {
        $isOnline = Dates::isOnline($request->chosenDate);

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

    public function chooseHour(Request $request)
    {
        $hours = Dates::hours($request->chosenDate);

        $html = '';
        for ($currentHour = $hours->startHour; $currentHour < $hours->endHour; $currentHour++) {
            //Check if space left
            $bookingRecordsAmount = Booking::bookingRecordsAmount($request->chosenDate, $request->roomID, $currentHour);

            $roomSpace = Rooms::roomSpace($request->roomID);

            $leftSpace = $roomSpace->roomSpace - $bookingRecordsAmount;

            if ($leftSpace < 1) {
                $html .= '<option value="" disabled>'  . __('C') . ' ' . $currentHour . ':00 ' . __('до') . ' ' .
                    ($currentHour + 1) . ':00 (' . __('Все места заняты') . ')</option>';
            } else {
                $html .= '<option value="' . $currentHour . '">' . __('C') . ' ' . $currentHour . ':00 ' . __('до') . ' ' .
                    ($currentHour + 1) . ':00 (' . __('Осталось') . ' ' .
                    $leftSpace . ' ' . __('мест') . ')</option>';
            }
        }

        return $html;
    }

    public function complete(Request $request)
    {
        $requestData = $this->requestCheck($request);

        if ($requestData instanceof \Illuminate\Http\RedirectResponse) {
            return $requestData;
        }

        if ($request->roomID == 'isOnline') {
            $data = array(
                'bookingdate' => $request->chosenDate,
                'requestID' => $request->requestID,
                'isOnline' => true
            );

            Booking::insert($data);
            Requests::updateTo($request->requestID, 2);

            return redirect('/Index?message=' . __('Вы успешно выбрали дату пересдачи') . ' ' . $request->chosenDate . ' ' . __('в онлайн формате'));
        } else {
            $data = array(
                'bookingdate' => $request->chosenDate,
                'requestID' => $request->requestID,
                'isOnline' => false,
                'startHour' => $request->startHour,
                'roomID' => $request->roomID,
            );

            //Check if space left
            $bookingRecordsAmount = Booking::bookingRecordsAmount($request->chosenDate, $request->roomID, $request->startHour);

            $roomSpace = Rooms::roomSpace($request->roomID);

            $leftSpace = $roomSpace->roomSpace - $bookingRecordsAmount;

            if ($leftSpace < 1) {
                return redirect('/Index?error=' . __('Свободных мест не осталось') . '');
            }

            Booking::insert($data);
            Requests::updateTo($request->requestID, 2);

            $roomName = Rooms::get($request->roomID);
            return redirect('/Index?message=' . __('Вы успешно выбрали дату пересдачи') . ' ' . $request->chosenDate
                . ', ' . __('в аудитории') . ': ' . $roomName->roomName . ', С ' . $request->startHour . ':00' .
                ' до ' . (($request->startHour) + 1) . ':00');
        }
    }
}
