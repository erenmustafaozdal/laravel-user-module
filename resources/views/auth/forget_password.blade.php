@extends(config('laravel-user-module.views.auth.layout'))

@section('title')
    {!! trans('laravel-user-module::auth.forget_password.title') !!}
@stop

@section('content')
    {{-- Login Form --}}
    <div class="form">
        <section class="login_content">
            {!! Form::open([
                'method' => 'POST',
                'url' => route('postForgetPassword')
            ]) !!}
                <h1>{!! trans('laravel-user-module::auth.forget_password.title') !!}</h1>
                {{-- Error Messages --}}
                @include('laravel-user-module::partials.error_message')
                <div>
                    {!! Form::text( 'email', null, [
                        'class' => 'form-control',
                        'placeholder' => trans('laravel-user-module::auth.forget_password.email'),
                        'value' => old('email')
                    ]) !!}
                </div>
                <div>
                    {!! Form::button( trans('laravel-user-module::auth.forget_password.submit'), [
                        'class' => 'btn btn-default submit',
                        'type' => 'submit'
                    ]) !!}
                    <a class="reset_pass" href="{!! route('getLogin') !!}">
                        {!! trans('laravel-user-module::auth.forget_password.login') !!}
                    </a>
                </div>
                <div class="clearfix"></div>
                <div class="separator">

                    <p class="change_link">
                        {!! trans('laravel-user-module::auth.forget_password.register_message') !!}
                        <a href="{!! route('getRegister') !!}" class="to_register">
                            {!! trans('laravel-user-module::auth.forget_password.register') !!}
                        </a>
                    </p>
                    <div class="clearfix"></div>
                    @include('laravel-user-module::auth.auth_footer')
                </div>
            {!! Form::close() !!}
        </section>
    </div>
@endsection