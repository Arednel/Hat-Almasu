<div>
    <label for="search">Поиск по id</label>
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

<script src="{{ asset('scripts/jquery-3.6.4.min.js') }}"></script>
<script>
    var keyupTimer;
    var timeMS = 1000;

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
