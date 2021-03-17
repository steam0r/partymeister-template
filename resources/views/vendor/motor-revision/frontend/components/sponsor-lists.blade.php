@foreach ($sponsors as $sponsor)
    <div class="media-object">
        <div class="media-object-section">
            <div class="thumbnail" style="width: 200px; border: none !important;">
                <a href="{{$sponsor->url}}">
                <img src="{{$sponsor->file_associations()->where('identifier', 'logo_big')->first()->file->getFirstMedia('file')->getUrl('thumb')}}" style="width: 100%;">
                </a>
            </div>
        </div>
        <div class="media-object-section">
            <h4 style="text-align: left;">{{$sponsor->name}} <span style="display: inline-block; float: right;">{{trans('motor-revision::backend/sponsors.levels.'.$sponsor->level)}}</span></h4>
            {!! $sponsor->text !!}
        </div>
    </div>
@endforeach
