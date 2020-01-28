<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

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

        .full-content, .content-sidebar {
            opacity: 0.95;
            border-radius: 20px;
            background: #faf4e7;
            position: relative;
            top: 220px;
            padding: 1.5rem;
            margin-bottom: 6.5rem;
            box-shadow: 5px 5px 5px #353739;
            border: 1px solid #353739;
        }
        .full-content {
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
            border-right: none;
        }

        .content-sidebar {
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
            border-left: 1px solid #dedede;
        }

        html {
            background: url(/images/frontend/revision-2020-bg.jpg) no-repeat center center fixed;
            background-size: cover;
        }

        #headline {
            width: 22%;
            min-width: 180px;
            position: fixed;
            top: 75px;
            left: 5%;
        }

        #subline {
            position: fixed;
            right: 5%;
            text-align: right;
            top: 110px;
            font-size: 30px;
            color: #f6e9d1;
            line-height: 40px;
            font-family: 'Roboto Condensed', sans-serif;
        }

        #subline small {
            font-size: 20px;
        }

        .footer, .top-bar {
            background: #fcf9f3;
            opacity: 1;
            height: 3rem;
            padding: 0;
        }
        .top-bar {
            justify-content: center;
            opacity: 1;
            z-index: 10000;
        }

        .top-bar ul {
            background: #fcf9f3;
            z-index: 10000;
        }

        .footer ul.menu a {
            font-family: 'Roboto Condensed', sans-serif !important;
        }

        .menu .active > a {
            background: #71854d;
        }

        .dropdown.menu > li.is-active > a {
            color: #71854d;
        }

        .dropdown.menu > li.is-dropdown-submenu-parent > a::after {
            border-color: #71854d transparent transparent;
        }

        .button.success {
            background-color: #71854d;
            color: white;
        }

        .callout.primary {
            background-color: #c2cfd4;
        }

        @media only screen
        and (max-device-width: 667px) {
            #headline {
                top: 3%;
            }

            #subline {
                top: 16%;
                font-size: 20px;
            }
        }

        .thumbnail img {
            width: 100vw;
        }

        .thumbnail.float-right, .thumbnail.float-left {
            max-width: 50%;
            margin-bottom: 1rem;
        }

        .thumbnail.float-right {
            margin-left: 1rem;
        }

        .thumbnail.float-left {
            margin-right: 1rem;
        }
    </style>
</head>
<body>
<a href="/">
    <img src="/images/frontend/revision-2020-headline.png" id="headline">
</a>
<p id="subline">
    Revision - April 10th to 13th 2020<br>
    E Werk Saarbrücken, Germany
</p>
@include('motor-cms::layouts.frontend.partials.navigation')
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
