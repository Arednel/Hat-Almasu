<link rel="stylesheet" href="{{ asset('css/Search.css') }}" />

<div class="search">
    <label for="search">Введите данные для поиска</label>
    <input type="search" id="search" name="search">
    <label for="search">Вариант поиска</label>
    <select id="searchType" name="searchType" required>
        <option value="requestID">ID</option>
        <option value="idOfTest">ID теста</option>
        <option value="department">Отделение</option>
        <option value="course">Курс</option>
        <option value="fullName">ФИО</option>

        <option value="faculty">Институт</option>
        <option value="speciality">Специальность</option>

        <option value="subject">Дисциплина</option>
        <option value="mail">Почта</option>
        <option value="phoneNumber">Телефон</option>
        <option value="reason">Причина</option>
        <option value="examType">Вид Экзамена</option>
    </select>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"
    integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
<script>
    var keyupTimer;
    var timeMS = 800;

    function search() {
        clearTimeout(keyupTimer);
        keyupTimer = setTimeout(function() {
            var searchRequest = $("#search").val();
            var searchType = $("#searchType").val();
            $.ajax({
                type: 'GET',
                url: '/Requests/Search',
                data: {
                    statusType: '{{ $statusType }}',
                    currentPage: '{{ $currentPage }}',
                    searchRequest: searchRequest,
                    searchType: searchType
                },
                success: function(requests) {
                    $('tbody').empty();
                    $('tbody').append(requests);
                }
            });
        }, timeMS);
    }

    $("#search").on("input", function() {
        search();
    });
    $('#searchType').change(function() {
        search();
    });
</script>
