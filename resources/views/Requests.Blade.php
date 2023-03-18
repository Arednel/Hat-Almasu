<!DOCTYPE html>

<html>

<head>
    <title>@php echo Session::get('requestsTitle') @endphp</title>
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/employeeFandT.css') }}">
    <link rel="stylesheet" href="{{ asset('css/betterTable.css') }}">
</head>

<?php
// require '../pageSwitching/pageSwitchingGet.php';
?>

@include('./NavBarAndFooter/navBar')
@include('./NavBarAndFooter/footer')

<body>
    <div class="main-body">
        <?php
        // require '../pageSwitching/pageSwitchingDiv.php';
        ?>
        <table class="tableE">
            <thead class="tableE-head">
                <tr>
                    <th class="columnE">ID</th>
                    <th class="columnE">ФИО </th>
                    <th class="columnE">ID теста / Институт / Специальность / Курс / Отделение / Дисциплина</th>
                    <th class="columnE">Почта / Телефон</th>
                    <th class="columnE">Причина </th>
                    <th class="columnE">Подтверждающий документ</th>
                    @php
                        if (in_array(Session::get('userPrivilege'), ['Admin', 'Support'])) {
                            echo '<th class="columnE">Решение</th>';
                        }
                    @endphp
                </tr>
            </thead>
            <tbody class="tableE-body">
                @php
                    $greyRow = false;
                @endphp

                @foreach ($result as $record)
                    {{-- fix that, it's awful --}}
                    @if ($greyRow)
                        @php
                            $classGrey = '-grey';
                        @endphp
                    @else
                        @php
                            $classGrey = '';
                        @endphp
                    @endif
                    @php
                        $greyRow = !$greyRow;
                    @endphp
                    {{-- fix that, it's awful --}}

                    <tr>
                        <td class="columnE">
                            <div class="columnText">{{ $record->requestID }}
                            </div>
                        </td>
                        <td class="columnE">
                            <div class="columnText">{{ $record->fullName }}
                            </div>
                        </td>
                        <td class="columnE">
                            <div class="columnText">{{ $record->idOfTest }} / {{ $record->faculty }} /
                                {{ $record->speciality }} /
                                {{ $record->course }} / {{ $record->department }} / {{ $record->subject }}</div>
                        </td>
                        <td class="columnE">
                            <div class="columnText">
                                {{ $record->mail }}/<br>
                                {{ $record->phoneNumber }}
                            </div>
                        </td>
                        <td class="columnE">
                            <div class="columnText">
                                {{ $record->reason }}
                            </div>
                        </td>
                        <td class="columnE">
                            <input onclick="goToImage('{{ $record->requestID }} ')" type="button"
                                value="Перейти к файлу" class="calendar-button{{ $classGrey }} '">
                        </td>
                        @if (in_array(Session::get('userPrivilege'), ['Admin', 'Support']))
                            @if (Session::get('statusType') == 'new')
                                <td class="columnE">
                                    <input onclick="setisApproved({{ $record->requestID }} , 1)" type="button"
                                        value="✓" class="calendar-button{{ $classGrey }}-green-to-hover">
                                    <input onclick="setisApproved({{ $record->requestID }}, 0)" type="button"
                                        value="X" class="calendar-button{{ $classGrey }}-red-to-hover">
                                @elseif (Session::get('statusType') == 'approved')
                                <td class="columnE">
                                    <input onclick="setisApproved({{ $record->requestID }}, 1)" type="button"
                                        value="✓" class="calendar-button{{ $classGrey }}-green-to-hover">
                                    <input onclick="setisApproved({{ $record->requestID }}, 0)" type="button"
                                        value="X" class="calendar-button{{ $classGrey }}-red-to-hover">
                                @elseif (Session::get('statusType') == 'rejected')
                                <td class="columnE">
                                    <input onclick="setisApproved({{ $record->requestID }}, 1)" type="button"
                                        value="✓" class="calendar-button{{ $classGrey }}-green-to-hover">
                            @endif
                            </td>
                        @endif
                    </tr>
                @endforeach

            </tbody>
        </table>
        <?php
        // require '../pageSwitching/pageSwitchingDiv.php';
        ?>
        <form action="excelExport.php" method="POST" class="excel-download-form">
            <input type="hidden" name="statusType" value=<?php echo Session::get('statusType'); ?> />
            {{-- <input type="hidden" name="offSet" value="<?php //echo $offSet;
            ?>" />
            <input type="hidden" name="perPage" value="<?php //echo $perPage;
            ?>" /> --}}
            <input type="submit" value="Скачать эту страницу" class="button-blue">
        </form>
        <form action="excelExport.php" method="POST" class="excel-download-form">
            <input type="hidden" name="statusType" value=<?php echo Session::get('statusType'); ?> />
            <input type="submit" value="Скачать все страницы" class="button-blue">
        </form>
    </div>
</body>

<script src="{{ asset('scripts/sort.js') }}"></script>
<script src="{{ asset('scripts/goToImage.js') }}"></script>
@if (in_array(Session::get('userPrivilege'), ['Admin', 'Support']))
    <script src="{{ asset('scripts/setisApproved.js') }}"></script>
@endif

</html>
