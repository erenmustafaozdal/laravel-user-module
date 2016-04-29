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

<body class="nav-md">

    <div class="container body">

        <div class="main_container">

            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">

                    <div class="navbar nav_title" style="border: 0;">
                        {!! HTML::link(
                            '#',
                            config('laravel-user-module.app_name'),
                            ['class' => 'site_title']
                        ) !!}
                    </div>
                    <div class="clearfix"></div>

                    {{-- menu profile quick info --}}
                    <div class="profile">
                        <div class="profile_pic">
                            @if( is_null($auth_user->photo) )
                                {!! HTML::image(
                                    'vendor/laravel-user-module/img/avatar.png',
                                    $auth_user->fullname,
                                    ['class' => 'img-circle profile_img']
                                ) !!}
                            @else
                                {!! HTML::image(
                                    $auth_user->photo_url,
                                    $auth_user->fullname,
                                    ['class' => 'img-circle profile_img']
                                ) !!}
                            @endif
                        </div>
                        <div class="profile_info">
                            <span>{!! trans('laravel-user-module::admin.welcome') !!},</span>
                            <h2>{{ $auth_user->first_name }}</h2>
                        </div>
                    </div>
                    {{-- /menu profile quick info --}}

                    {{-- sidebar menu --}}
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                        <div class="menu_section">
                            <h3>{!! trans('laravel-user-module::admin.title') !!}</h3>
                            <ul class="nav side-menu">
                                @section('sidebar')
                                    This is the master sidebar.
                                @show
                            </ul>
                        </div>
                    </div>
                    {{-- /sidebar menu --}}

                </div>
            </div>

        </div>

    </div>

</body>

<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</html>