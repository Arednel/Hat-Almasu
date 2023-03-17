<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class BookingInsertController extends Controller
{
    public function insert(Request $request)
    {
        //Limitation of request amount (one request per 3 minutes)
        if (null !== Session::get('lastRequestTime')) {
            $currentFullTime = date('d-m-Y h:i:s');
            $to_time = strtotime(Session::get('lastRequestTime'));
            $from_time = strtotime($currentFullTime);
            $diffirenceBetweenTime = round(abs($to_time - $from_time) / 60, 2);
            if ($diffirenceBetweenTime < 3) {
                return redirect('Index?error=Подождите 3 минуты, перед подачей следующей заявки');
            }
        }

        //Data valifation
        $formFields = $request->validate(
            [
                'fullName' => 'required',
                'idOfTest' => [
                    'required', Rule::unique('requests', 'idOfTest')
                ],
                'course' => 'required',
                'faculty' => 'required',
                'department' => 'required',
                'speciality' => 'required',
                'subject' => 'required',
                'mail' => ['required', 'email'],
                'phoneNumber' => 'required',
                'reason' => 'required',
                'confirmationFile' => 'required'
            ]
        );

        $fullName = $request->input('fullName');
        $idOfTest = $request->input('idOfTest');
        $faculty = $request->input('faculty');
        $course = $request->input('course');
        $department = $request->input('department');
        $speciality = $request->input('speciality');
        $subject = $request->input('subject');
        $mail = $request->input('mail');
        $phoneNumber = $request->input('phoneNumber');
        $reason = $request->input('reason');
        $image = $request->file('confirmationFile');

        //Image save and checking size (8MB)
        if ($image) {
            $uploadedFile = $image->getRealPath();
            if (filesize($uploadedFile) > 8388608) {
                return redirect('Index?error=Файл слишком большой');
            }
            clearstatcache();

            $bin_string = file_get_contents($image->getRealPath());
            $confirmationFile = base64_encode($bin_string);
        } else {
            return redirect('Index?error=Ошибка связанная с файлом');
        }

        $data = array(
            'fullName' => $fullName, "idOfTest" => $idOfTest, "faculty" => $faculty, "course" => $course,
            "department" => $department, "speciality" => $speciality, "subject" => $subject, "mail" => $mail, "phoneNumber" => $phoneNumber,
            "reason" => $reason, "confirmationFile" => $confirmationFile
        );
        DB::table('requests')->insert($data);

        $requestID = DB::getPdo()->lastInsertId();

        Session::put('lastRequestTime', date('d-m-Y h:i:s'));

        return redirect('Index?message=Вы успешно подали заявку, ваш номер заявки: ' . $requestID . '   Сохраните этот номер!');
    }
}
