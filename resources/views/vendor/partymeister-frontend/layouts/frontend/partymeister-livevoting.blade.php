<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Live Voting</title>

    <link rel="stylesheet" href="{{mix('css/partymeister-livevoting.css')}}">
    @yield('view_styles')
    <style type="text/css">
    </style>
</head>
<body>
@include('motor-cms::layouts.frontend.partials.template-sections', ['rows' => $template['items']])
<script type="text/javascript" src="{{mix('js/partymeister-livevoting.js')}}"></script>
@yield('view-scripts')
</body>
</html>
