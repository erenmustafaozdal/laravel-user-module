<ul class="nav navbar-nav navbar-right">

    <li class="">
        <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            @if( is_null($auth_user->photo) )
                {!! HTML::image(
                    'vendor/laravel-user-module/img/avatar.png',
                    $auth_user->fullname
                ) !!}
            @else
                {!! HTML::image(
                    $auth_user->photo_url,
                    $auth_user->fullname
                ) !!}
            @endif
            <span>{{ $auth_user->first_name }}</span>
            <span class=" fa fa-angle-down"></span>
        </a>

        {{-- Topbar user menu --}}
        <ul class="dropdown-menu dropdown-usermenu pull-right">
            @foreach($usermenu_items as $item)
                <li {{ (strpos(Route::currentRouteName(),$item->attribute('active')) !== false) ? 'class=active' : '' }}>
                    <a href="{{ $item->url() }}">
                        <i class="fa fa-{{ $item->attribute('data-icon') }}"></i>
                        <span>{!! $item->title !!}</span>
                    </a>
                </li>
            @endforeach
        </ul>
        {{-- /Topbar user menu --}}

    </li>

</ul>