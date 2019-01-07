@section('view-styles')
<style type="text/css">
    .seat {
        display: inline-block;
        position: relative;
        top: 7px;
        margin: 0 4px;
        width: 17px;
        height: 25px;
        background-size: cover;
        background-image:
            url('data:image/svg+xml;utf8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20xmlns%3Axlink%3D%22http%3A%2F%2Fwww.w3.org%2F1999%2Fxlink%22%20version%3D%221.1%22%20x%3D%220px%22%20y%3D%220px%22%20viewBox%3D%220%200%20100%20125%22%20enable-background%3D%22new%200%200%20100%20100%22%20xml%3Aspace%3D%22preserve%22%3E%3Cpath%20fill%3D%22%23000000%22%20d%3D%22M83.028%2C57.888l-0.049-0.013c0%2C0-0.411-0.109-1.011-0.136c-0.225-0.026-0.412-0.087-0.664-0.087h-23.15%20%20c0%2C0-0.264%2C0.004-0.648%2C0.064c-0.228-0.008-0.463-0.006-0.715%2C0.017l-19.346%2C1.692l-3.387-9.307h29.991c0%2C0%2C4.502%2C0%2C4.502-4.502%20%20v-0.052c0%2C0%2C0-4.503-4.502-4.503H30.762l-5.735-15.756c0%2C0-0.01-0.026-0.021-0.052V9.254c0%2C0%2C0-6.754-6.753-6.754%20%20c0%2C0-6.753%2C0-6.753%2C6.754v16.857c0%2C0%2C0.008%2C1.133%2C0.469%2C2.468c0.082%2C0.43%2C0.193%2C0.874%2C0.366%2C1.348l15.678%2C43.076%20%20c0%2C0%2C0.396%2C1.063%2C1.289%2C2.162c0.951%2C1.396%2C2.591%2C2.609%2C5.451%2C2.609h14.365v11.571H30.629c0%2C0-3.377%2C0-3.377%2C3.377v0.401%20%20c0%2C0%2C0%2C3.376%2C3.377%2C3.376h45.893c0%2C0%2C3.376%2C0%2C3.376-3.376v-0.401c0%2C0%2C0-3.377-3.376-3.377H58.033V77.774h18.188%20%20c0%2C0%2C0.035-0.001%2C0.092-0.003h2.416c1.355%2C0.065%2C3.71-0.286%2C4.521-3.316l2.963-11.054C86.213%2C63.401%2C87.377%2C59.053%2C83.028%2C57.888%22%2F%3E%3C%2Fsvg%3E');
    }
</style>
@endsection
<div class="callout primary">
    <p>
        {{$visitors->count()}} people are registered for Revision 2019!
    </p>
</div>

<div class="grid-x">
    @foreach ($visitors as $v)
        <div class="cell medium-6 small-12">
            <span class="flag-icon flag-icon-{{strtolower($v->country_iso_3166_1)}}" title="{{strtoupper($v->country_iso_3166_1)}}"></span>
            <span class="seat" title="{{ isset($v->additional_data['seat']) ? $v->additional_data['seat'].' ('.$v->additional_data['boardingpass'].')' : '' }}"> </span>
            {{$v->name}} @if ($v->group != '') / {{$v->group}} @endif
        </div>
    @endforeach
</div>