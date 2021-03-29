@foreach(config('partymeister-slides-fonts.fonts') as $index => $font)
    <link href="{{$font['path']}}" rel="stylesheet">
@endforeach