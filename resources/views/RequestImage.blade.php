<!DOCTYPE html>

<html>

<head>
    <title>Файл заявки</title>
</head>

<style>
    img {
        max-width: 100%;
    }
</style>

<body>

    @if ($image->confirmationFile)
        <img src="data:image/png;base64,{{ $image->confirmationFile }}" />
    @else
        Файл отсутствует
    @endif

</body>

</html>
