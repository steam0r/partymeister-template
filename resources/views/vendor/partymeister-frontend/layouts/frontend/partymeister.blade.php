<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>{{$version->name}} | {{config('motor-backend-project.name_frontend')}}</title>

    <link href="{{ mix('/css/motor-frontend.css') }}" rel="stylesheet" type="text/css"/>
    @yield('view-styles')
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed&display=swap" rel="stylesheet">
    <link href="/css/revision-2021.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<img src="/images/frontend/revision-2020-headline.png" id="headline">
<p id="footer">
    Revision - April 2nd to 5th 2021<br>
    Streamed on twitch.tv
</p>
{{--@include('motor-cms::layouts.frontend.partials.navigation')--}}
<div class="grid-container" style="margin-bottom: 8rem;">
    @include('motor-cms::layouts.frontend.partials.template-sections', ['rows' => $template['items']])
</div>
<div class="columns shrink footer text-center" style="position: fixed; bottom: 0; width: 100%;">
    @foreach (\Motor\Revision\Models\Sponsor::where('is_active', true)->orderBy('level', 'ASC')->orderBy('sort_position', 'ASC')->get() as $sponsor)
        <a href="{{$sponsor->url}}"><img src="{{$sponsor->file_associations()->where('identifier', 'logo_small')->first()->file->getFirstMedia('file')->getUrl('thumb')}}" style="max-height: 50px; max-width: 200px;"></a>
    @endforeach
    <ul class="menu align-center">
        <li><a href="/privacy">Privacy policy</a></li>
        <li><a href="/contact">Contact and Imprint</a></li>
    </ul>
</div>
<script src="{{mix('js/partymeister-frontend.js')}}"></script>
@yield('view-scripts')
<script>
    $(document).foundation();
</script>
</body>
</html>
