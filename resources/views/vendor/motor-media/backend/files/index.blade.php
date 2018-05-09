@extends('motor-backend::layouts.backend')

@section('htmlheader_title')
    {{ trans('motor-backend::backend/global.home') }}
@endsection

@section('contentheader_title')
    {{ trans('motor-media::backend/files.files') }}
    @if (has_permission('files.write'))
        {!! link_to_route('backend.files.create', trans('motor-media::backend/files.new'), [], ['class' => 'float-right btn btn-sm btn-success']) !!}
    @endif
    @include('partymeister-slides::layouts.partials.slide_clients_controls')
@endsection

@section('main-content')
    <div class="@boxWrapper">
        <div class="@boxHeader">
            @include('motor-backend::layouts.partials.search')
        </div>
        <!-- /.box-header -->
        @if (isset($grid))
            @include('motor-backend::grid.table')
        @endif
    </div>
@endsection

@include('partymeister-slides::layouts.partials.slide_clients_scripts')
@section('view_scripts')
    <script type="text/javascript">
        $('.delete-record').click(function (e) {
            if (!confirm('{{ trans('motor-backend::backend/global.delete_question') }}')) {
                e.preventDefault();
                return false;
            }
        });
    </script>
@append