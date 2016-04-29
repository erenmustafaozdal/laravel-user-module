@extends(config('laravel-user-module.views.user.layout'))

@section('title')
    {!! trans('laravel-user-module::auth.login.title') !!}
@stop

@section('js')
    {!! Html::script('vendor/laravel-user-module/js/adminDatatable.js') !!}
@stop

@section('content')
    sasa
@endsection