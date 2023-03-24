<?php

namespace App\Http\Controllers;

use App\Models\Dates;
use App\Models\Rooms;
use App\Models\Booking;
use App\Models\Requests;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OccupancyController extends Controller
{
    private function viewOccupancy($result)
    {
        $requests = collect([]);
        foreach ($result as $value) {
            $requestDate = Requests::one($value->requestID);
            $requests->push($requestDate);
        }

        return view('OccupancyTable', [
            'result' => $requests
        ]);
    }

    public function chooseDate()
    {
        if (!(in_array(Session::get('userPrivilege'), ['Admin', 'Support', 'Viewer']))) {
            return redirect('/Index?error=У вас недостаточный уровень доступа!');
        }

        $availabledates = Dates::all();

        return view('Occupancy', ['availabledates' => $availabledates]);
    }

    public function chooseRoom(Request $requestDataFromUser)
    {
        if (!(in_array(Session::get('userPrivilege'), ['Admin', 'Support', 'Viewer']))) {
            return redirect('/Index?error=У вас недостаточный уровень доступа!');
        }

        $isOnline = Dates::isOnline($requestDataFromUser->date);

        if ($isOnline->isOnline) {
            $result = Booking::selectWhereOnline($requestDataFromUser->date);

            return $this->viewOccupancy($result);
        } else {
            $rooms = Rooms::all();

            return view('Occupancy', [
                'chosenDate' => $requestDataFromUser->date, 'rooms' => $rooms
            ]);
        }
    }

    public function chooseHour(Request $requestDataFromUser)
    {
        if (!(in_array(Session::get('userPrivilege'), ['Admin', 'Support', 'Viewer']))) {
            return redirect('/Index?error=У вас недостаточный уровень доступа!');
        }

        $hours = Dates::hours($requestDataFromUser->chosenDate);

        $amountOfHours = $hours->endHour - $hours->startHour;

        return view('Occupancy', [
            'chosenDate' => $requestDataFromUser->chosenDate, 'roomID' =>  $requestDataFromUser->roomID,
            'startHour' =>  $hours->startHour, 'hours' =>  $amountOfHours
        ]);
    }

    public function view(Request $requestDataFromUser)
    {
        if (!(in_array(Session::get('userPrivilege'), ['Admin', 'Support', 'Viewer']))) {
            return redirect('/Index?error=У вас недостаточный уровень доступа!');
        }

        $result = Booking::selectWhereOffline($requestDataFromUser->chosenDate, $requestDataFromUser->startHour, $requestDataFromUser->roomID);

        return $this->viewOccupancy($result);
    }
}
