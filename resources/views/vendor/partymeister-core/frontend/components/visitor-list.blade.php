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
            url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" viewBox="0 0 100 125" enable-background="new 0 0 100 100" xml:space="preserve"><path fill="#000000" d="M83.028,57.888l-0.049-0.013c0,0-0.411-0.109-1.011-0.136c-0.225-0.026-0.412-0.087-0.664-0.087h-23.15  c0,0-0.264,0.004-0.648,0.064c-0.228-0.008-0.463-0.006-0.715,0.017l-19.346,1.692l-3.387-9.307h29.991c0,0,4.502,0,4.502-4.502  v-0.052c0,0,0-4.503-4.502-4.503H30.762l-5.735-15.756c0,0-0.01-0.026-0.021-0.052V9.254c0,0,0-6.754-6.753-6.754  c0,0-6.753,0-6.753,6.754v16.857c0,0,0.008,1.133,0.469,2.468c0.082,0.43,0.193,0.874,0.366,1.348l15.678,43.076  c0,0,0.396,1.063,1.289,2.162c0.951,1.396,2.591,2.609,5.451,2.609h14.365v11.571H30.629c0,0-3.377,0-3.377,3.377v0.401  c0,0,0,3.376,3.377,3.376h45.893c0,0,3.376,0,3.376-3.376v-0.401c0,0,0-3.377-3.376-3.377H58.033V77.774h18.188  c0,0,0.035-0.001,0.092-0.003h2.416c1.355,0.065,3.71-0.286,4.521-3.316l2.963-11.054C86.213,63.401,87.377,59.053,83.028,57.888"/></svg>');
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