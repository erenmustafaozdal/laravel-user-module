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