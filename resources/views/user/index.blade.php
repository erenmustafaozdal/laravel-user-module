@extends(config('laravel-user-module.views.user.layout'))

@section('title')
    {!! trans('laravel-user-module::admin.user.index') !!}
@endsection

@section('page-title')
    <h1>{!! trans('laravel-user-module::admin.user.index') !!}
        <small>{!! trans('laravel-user-module::admin.user.index_description') !!}</small>
    </h1>
@endsection

@section('js')
    {!! Html::script('vendor/laravel-user-module/js/adminDatatable.js') !!}
@endsection

@section('content')
    sasa
@endsection