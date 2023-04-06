<link rel="stylesheet" href="{{ asset('css/ExcelExport.css') }}" />

<div class="excel-export">
    <button type="button" target="_blank"
        onclick="window.location=('/ExcelExport/{{ $statusType }}/{{ $currentPage }}')" class="button-blue-excel">
        Скачать эту страницу
    </button>
    <br>
    <button type="button" target="_blank" onclick="window.location=('/ExcelExportAll/{{ $statusType }}')"
        class="button-blue-excel">
        Скачать все страницы
    </button>
</div>
