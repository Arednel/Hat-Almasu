<?php

namespace App\Http\Controllers;

use App\Models\Dates;
use App\Models\Rooms;
use App\Models\Booking;
use App\Models\Requests;

use Illuminate\Http\Request;

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

    public function dates()

    {
        $availabledates = Dates::all();

        return view('Occupancy', ['availabledates' => $availabledates]);
    }

    public function chooseRoom(Request $request)
    {
        $isOnline = Dates::isOnline($request->chosenDate);

        if ($isOnline->isOnline) {
            return $isOnline;
        } else {
            $rooms = Rooms::all(Dates::dateExamSessionID($request->chosenDate));

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

            $bookingRecordsAmount = Booking::bookingRecordsAmount($request->chosenDate, $request->roomID, $currentHour);

            $roomSpace = Rooms::roomSpace($request->roomID);

            $html .= '<option value="' . $currentHour . '">
            ' . __('C') . ' ' . $currentHour . ':00 ' . __('до') . ' ' . ($currentHour + 1) . ':00 
            (Занято ' . $bookingRecordsAmount . ' ' . __('мест') . ' из ' . $roomSpace->roomSpace . ' )</option>';
        }

        return $html;
    }

    public function view(Request $request)
    {
        if ($request->roomID == 'isOnline') {
            $result = Booking::selectWhereOnline($request->chosenDate);

            return $this->viewOccupancy($result);
        }
        $result = Booking::selectWhereOffline($request->chosenDate, $request->startHour, $request->roomID);

        return $this->viewOccupancy($result);
    }
}
