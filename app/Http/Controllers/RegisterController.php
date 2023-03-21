<?php

namespace App\Http\Controllers;

use App\Models\Dates;
use App\Models\Booking;
use App\Models\Requests;

use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function chooseDate(Request $requestDataFromUser)
    {
        $requestDataFromUser->validate(
            [
                'mail' => ['required', 'email'],
                'requestID' => 'required'
            ]
        );

        $requestData = Requests::requestIDMailStatus($requestDataFromUser->requestID);

        if ($requestData == null) {
            return redirect('/Index?error=Заявки не существует');
        }

        if (
            $requestData->requestID == $requestDataFromUser->requestID
            &&
            $requestData->mail == $requestDataFromUser->mail
        ) {
            switch ($requestData->requestStatus) {
                case 0:
                    return redirect('/Index?messageokay=Заявка рассматривается');
                case 1:
                    $isOnline = Dates::isOnline($requestDataFromUser->date);

                    if ($isOnline->isOnline) {
                        $data = array(
                            'bookingdate' => $requestDataFromUser->date,
                            'requestID' => $requestDataFromUser->requestID,
                            'isOnline' => true
                        );

                        Booking::insert($data);
                        Requests::updateToChosen($requestDataFromUser->requestID);

                        return redirect('/Index?message=Вы успешно выбрали дату пересдачи');
                    } else {
                        return view('Register', [
                            'requestID' => $requestDataFromUser->requestID, 'mail' => $requestDataFromUser->mail,
                            'chosenDate' => $requestDataFromUser->date
                        ]);
                    }
                case 2:
                    return redirect('/Index?messageokay=Вы уже выбрали время');
                case 3:
                    return redirect('/Index?messageokay=Заявка была отклонена');
            }
        } else {
            return redirect('/Index?error=Указаны неверные данные');
        }
    }
}
