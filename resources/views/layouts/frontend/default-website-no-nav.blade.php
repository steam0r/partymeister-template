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
        body {
            background: transparent;
            font-family: 'Roboto Condensed', sans-serif;
        }
        a, li {
            font-family: 'Roboto Condensed', sans-serif;
        }
        p, h1, h2, h3, h4, h5, h6 {
            font-family: 'Roboto Condensed', sans-serif !important;
        }
        h1, h2, h3, h4, h5, h6 {
            text-align: center;
        }
        .grid-container {
            opacity: 0.95;
            max-width: 600px;
        }
        .full-content {
            border-radius: 20px;
            background: #faf4e7;
            position: relative;
            top: 200px;
            padding: 1.5rem;
            margin-bottom: 6.5rem;
            box-shadow: 5px 5px 5px #353739;
            border: 1px solid #353739;

        }
        html {
            background: url(/images/frontend/revision-2020-bg.jpg) no-repeat center center fixed;
            background-size: cover;
        }
        #headline {
            width: 25%;
            min-width: 200px;
            position: fixed;
            top: 5%;
            left: 5%;
        }
        #subline {
            position: fixed;
            right: 5%;
            text-align: right;
            top: 10%;
            font-size: 30px;
            color: #f6e9d1;
            font-family: 'Roboto Condensed', sans-serif;
        }
        #subline small {
            font-size: 20px;
        }
        .footer {
            background: #fcf9f3;
            opacity: 0.95;
            height: 3rem;
            padding: 0;
        }
        .footer ul.menu a {
            font-family: 'Roboto Condensed', sans-serif !important;
        }
        .button.success {
            background-color: #71854d;
            color: white;
        }
        .callout.primary {
            background-color: #c2cfd4;
        }
    </style>
</head>
<body>
<a href="/">
    <img src="/images/frontend/revision-2020-headline.png" id="headline">
</a>
<p id="subline">
    Revision - April 10th to 13th 2020<br>
</p>
{{--@include('motor-cms::layouts.frontend.partials.navigation')--}}
<div class="grid-container" style="margin-bottom: 8rem;">
    @include('motor-cms::layouts.frontend.partials.template-sections', ['rows' => $template['items']])
</div>
<div class="columns shrink footer text-center" style="position: fixed; bottom: 0; width: 100%;">
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
