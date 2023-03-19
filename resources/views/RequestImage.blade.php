<style>
    img {
        max-width: 100%;
    }
</style>


@if ($image->confirmationFile)
    <img src="data:image/png;base64,{{ $image->confirmationFile }}" />
@else
    Файл отсутствует
@endif
