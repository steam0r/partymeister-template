<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <title>{{$version->name}} | {{config('motor-backend-project.name_frontend')}}</title>

    <link href="{{ mix('/css/motor-frontend.css') }}" rel="stylesheet" type="text/css"/>
    @yield('view-styles')
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed&display=swap" rel="stylesheet">
    <link href="/css/revision-2021.css" rel="stylesheet" type="text/css"/>
</head>
<body>
@include('motor-cms::layouts.frontend.partials.navigation')
<div class="header" style="width: 100vw; height: 100px;">
    <h1>
        Together
        <span>Revision 2021 - on a sofa near you</span><br>
    </h1>
</div>
<div class="grid-container" style="margin-bottom: 8rem;">
    @include('motor-cms::layouts.frontend.partials.template-sections', ['rows' => $template['items']])
</div>
<div class="columns shrink footer text-center" style="position: fixed; bottom: 0; width: 100%; background: rgba(55, 60, 63, 1)">
    @foreach (\Motor\Revision\Models\Sponsor::where('is_active', true)->orderBy('level', 'ASC')->orderBy('sort_position', 'ASC')->get() as $sponsor)
        <a href="{{$sponsor->url}}"><img src="{{$sponsor->file_associations()->where('identifier', 'logo_small')->first()->file->getFirstMedia('file')->getUrl('thumb')}}" style="max-height: 50px; max-width: 200px;"></a>
    @endforeach
    <ul class="menu align-center">
        <li><a href="/privacy">Privacy policy</a></li>
        <li><a href="/contact">Contact and Imprint</a></li>
    </ul>
</div>
<script src="{{mix('js/motor-frontend.js')}}"></script>
@yield('view-scripts')
<script>
    $(document).foundation();
</script>
</body>
</html>
