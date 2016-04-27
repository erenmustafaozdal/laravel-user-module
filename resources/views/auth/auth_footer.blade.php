<div>
    <h1>{!! config('laravel-user-module.app_name') !!}</h1>

    <p>
        ©{!! config('laravel-user-module.copyright_year') !!}
        {!! str_replace(':app_name',config('laravel-user-module.app_name'),trans('laravel-user-module::global.copyright_message')) !!}
    </p>
</div>