<h1>First {{ $heading }}</h1>
@php
    $test = 0;
    $dateArray = [
        [
            'id' => '1',
            'title' => 'post one',
            'text' => 'something',
        ],
        [
            'id' => '2',
            'title' => 'post two',
            'text' => 'something',
        ],
        [
            'id' => '3',
            'title' => 'post three',
            'text' => 'something',
        ],
    ];
@endphp

@foreach ($dateArray as $post)
    @if ($test == 0)
        lol
        yes
    @endif
@endforeach

some text
