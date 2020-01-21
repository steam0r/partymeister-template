<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>{{$version->name}} | {{config('motor-backend-project.name_frontend')}}</title>

    <link href="{{ mix('/css/motor-frontend.css') }}" rel="stylesheet" type="text/css"/>
    @yield('view-styles')
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed&display=swap" rel="stylesheet">
    <style type="text/css">
        html {
            background: url(/images/frontend/revision-2020-bg.jpg) no-repeat center center fixed;
            background-size: cover;
        }
        #headline {
            width: 40%;
            min-width: 270px;
            position: absolute;
            top: 10%;
            left: 10%;
        }
        #footer {
            position: absolute;
            left: 15%;
            bottom: 10%;
            font-size: 30px;
            color: #f6e9d1;
            font-family: 'Roboto Condensed', sans-serif;
        }
        #footer small {
            font-size: 20px;
        }
    </style>
</head>
<body>
<img src="/images/frontend/revision-2020-headline.png" id="headline">
<p id="footer">
    Revision - April 10th to 13th 2020<br>
    E Werk Saarbrücken, Germany
</p>
{{--@include('motor-cms::layouts.frontend.partials.navigation')--}}
<div class="grid-container" style="margin-bottom: 8rem;">
    @include('motor-cms::layouts.frontend.partials.template-sections', ['rows' => $template['items']])
</div>
<div class="columns shrink footer text-center" style="position: fixed; bottom: 0; width: 100%;">
    <ul class="menu align-center">
        <li><a href="https://2019.revision-party.net/privacy_policy">Privacy policy</a></li>
    </ul>
</div>
<script src="{{mix('js/partymeister-frontend.js')}}"></script>
@yield('view-scripts')
<script>
    $(document).foundation();
</script>
</body>
</html>
