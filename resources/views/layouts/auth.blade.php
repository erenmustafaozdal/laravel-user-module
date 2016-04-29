<!DOCTYPE html>
<html lang="{!! config('laravel-user-module.views.html_lang') !!}">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="{!! config('laravel-user-module.views.html_head.content_type') !!}">
    <meta charset="{!! config('laravel-user-module.views.html_head.charset') !!}">
    <meta name="description" content="{!! config('laravel-user-module.views.html_head.meta_description') !!}"/>
    <meta name="author" content="{!! config('laravel-user-module.views.html_head.meta_author') !!}"/>
    <meta name="keywords" content="{!! config('laravel-user-module.views.html_head.meta_keywords') !!}"/>
    <meta name="robots" content="{!! config('laravel-user-module.views.html_head.meta_robots') !!}"/>
    <meta name="googlebot" content="{!! config('laravel-user-module.views.html_head.meta_googlebot') !!}"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | {!! config('laravel-user-module.views.html_head.default_title') !!}</title>

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-hQpvDQiCJaD2H465dQfA717v7lu5qHWtDbWNPvaTJ0ID5xnPUlVXnKzq7b8YUkbN" crossorigin="anonymous">
    {!! Html::style('vendor/laravel-user-module/css/global.css') !!}

</head>

<body style="background:#F7F7F7;">

<div>
    <div id="wrapper">
        @yield('content')
    </div>
</div>

</body>


{!! Html::script('vendor/laravel-user-module/js/login.js') !!}
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</html>