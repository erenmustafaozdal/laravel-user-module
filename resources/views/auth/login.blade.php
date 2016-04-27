@extends(config('laravel-user-module.views.auth.layout'))

@section('title')
    {!! trans('laravel-user-module::auth.login.title') !!}
@stop

@section('content')
    {{-- Login Form --}}
    <div class="form">
        <section class="login_content">
            {!! Form::open([
                'method' => 'POST',
                'url' => route('postLogin')
            ]) !!}
                <h1>{!! trans('laravel-user-module::auth.login.title') !!}</h1>
                {{-- Error Messages --}}
                @include('laravel-user-module::global.error_message')
                <div>
                    {!! Form::text( 'email', null, [
                        'class' => 'form-control',
                        'placeholder' => trans('laravel-user-module::auth.login.email'),
                        'value' => old('email')
                    ]) !!}
                </div>
                <div>
                    {!! Form::password( 'password', [
                        'class' => 'form-control',
                        'placeholder' => trans('laravel-user-module::auth.login.password')
                    ]) !!}
                </div>
                <div>
                    {!! Form::button( trans('laravel-user-module::auth.login.submit'), [
                        'class' => 'btn btn-default submit',
                        'type' => 'submit'
                    ]) !!}
                    <a class="reset_pass" href="{!! route('getForgetPassword') !!}">
                        {!! trans('laravel-user-module::auth.login.forget_password') !!}
                    </a>
                </div>
                <div class="clearfix"></div>
                <div class="separator">

                    <p class="change_link">
                        {!! trans('laravel-user-module::auth.login.register_message') !!}
                        <a href="{!! route('getRegister') !!}" class="to_register">
                            {!! trans('laravel-user-module::auth.login.register') !!}
                        </a>
                    </p>
                    <div class="clearfix"></div>
                    @include('laravel-user-module::auth.auth_footer')
                </div>
            {!! Form::close() !!}
        </section>
    </div>
@endsection