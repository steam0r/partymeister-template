@foreach(config('partymeister-slides-fonts.fonts') as $index => $font)
    <link href="{{$font['path']}}" rel="stylesheet">
@endforeach
<link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
