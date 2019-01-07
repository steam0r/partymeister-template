<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <title>REVISION 2019 – 19. - 22. APRIL 2019 – E WERK SAARBRÜCKEN, GERMANY</title>

    <link href="https://fonts.googleapis.com/css?family=Exo+2:400,600i&amp;subset=cyrillic,latin-ext" rel="stylesheet">
    <link href="{{ mix('/css/partymeister-frontend.css') }}" rel="stylesheet" type="text/css"/>
    @yield('view-styles')
    <style type="text/css">
        html {
            margin-bottom: 50px;
        }

        /*.pagebg-container {*/
            /*background: url('/images/r2019-bg.jpg');*/
            /*background-position: center top;*/
            /*background-repeat: no-repeat;*/
            /*background-size: cover;*/
            /*position: fixed;*/
            /*height: 100vh;*/
            /*width: 100%;*/
        /*}*/

        body {
            font-family: 'Exo 2', sans-serif;
            background: transparent;
            /*background: url('/images/r2019-bg.jpg');*/
            /*background-repeat: no-repeat;*/
            /*background-attachment: fixed;*/
            /*background-size: cover;*/
            z-index: 10;
        }

        body:after{
            content:"";
            position:fixed; /* stretch a fixed position to the whole screen */
            top:0;
            height:100vh; /* fix for mobile browser address bar appearing disappearing */
            left:0;
            right:0;
            z-index:-1; /* needed to keep in the background */
            background: url('/images/r2019-bg.jpg') center center;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }

        h1, h2, h3, h4, h5, h6 {
            color: white;
            font-family: 'Exo 2', sans-serif;
            font-weight: 600;
            font-style: italic;
            text-transform: uppercase;
            text-align: center;
            text-shadow: 0px 1px 1px rgba(0, 0, 0, 0.9);
        }

        .header.small div {
            position: fixed;
            margin: 5% auto;
            left: 0;
            right: 0;
            top: 150px;
        }

        .header.small img {
            position: fixed;
            width: 150px;
            height: auto;
            margin: 5% auto;
            left: 0;
            right: 0;
        }

        .header.small h1 {
            font-size: 2rem;
        }

        .header.small h2 {
            font-size: 1.5rem;
        }

        .header.small h4 {
            font-size: 1rem;
        }

        .header div {
            /*position: fixed;*/
            margin: 1rem auto 3rem;
            top: 250px;
        }

        .header img {
            margin-top: 50px;
            display: block;
            width: 250px;
            height: auto;
            margin-left: auto;
            margin-right: auto;
        }

        .button.success {
            background-color: #63c2dc;
        }

        .button.success:hover,
        .button.success:focus {
            background-color: #48bbdb;
        }
    </style>
</head>
<body>
<div id="pagebg-container"></div>
<div class="header">
    <img src="/images/r2019-logo.png">
    <div>
        <h1>Stay tuned</h1>
        <h2>we apologize for any inconvenience caused</h2>
        <h4>Revision 2019 &ndash; 19. - 22. April 2019 &ndash; E Werk Saarbrücken, Germany</h4>
    </div>
</div>
<div class="grid-container">
    <div class="grid-x">
        <div class="cell medium-offset-2 large-offset-2 medium-8 large-8 small-12">
            @include('motor-cms::layouts.frontend.partials.template-sections', ['rows' => $template['items']])
        </div>

        <div style="margin-top: 30px;" class="cell medium-offset-2 large-offset-2 medium-8 large-8 small-12 align-center" data-sticky-container>
            <div class="sticky" style="text-align: center;" data-stick-to="bottom" data-top-anchor="example3" data-btm-anchor="foo2:top">
                &copy; 2011 &dash; {{date('Y')}} Tastatur und Maus e.V | <a href="https://2018.revision-party.net/contact" target="_blank">Imprint</a>
            </div>
        </div>
    </div>
</div>

<script src="{{mix('js/partymeister-frontend.js')}}"></script>
@yield('view-scripts')
<script>
    $(document).foundation();
</script>
</body>
</html>