<!DOCTYPE html>

<html>

<head>
    <title>Файл заявки</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
