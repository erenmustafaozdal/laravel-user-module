@extends(config('laravel-user-module.views.auth.layout'))

@section('title')
    {!! trans('laravel-user-module::auth.reset_password.title') !!}
@stop

@section('content')
    {{-- Login Form --}}
    <div class="form">
        <section class="login_content">
            {!! Form::open([
                'method' => 'POST',
                'url' => route('postResetPassword')
            ]) !!}
                {!! Form::hidden( 'token', $token) !!}
                <h1>{!! trans('laravel-user-module::auth.reset_password.title') !!}</h1>
                {{-- Error Messages --}}
                @include('laravel-user-module::partials.error_message')
                <div>
                    {!! Form::text( 'email', null, [
                        'class' => 'form-control',
                        'placeholder' => trans('laravel-user-module::auth.reset_password.email'),
                        'value' => old('email')
                    ]) !!}
                </div>
                <div>
                    {!! Form::password( 'password', [
                        'class' => 'form-control',
                        'placeholder' => trans('laravel-user-module::auth.reset_password.password')
                    ]) !!}
                </div>
                <div>
                    {!! Form::password( 'password_confirmation', [
                        'class' => 'form-control',
                        'placeholder' => trans('laravel-user-module::auth.reset_password.password_confirmation')
                    ]) !!}
                </div>
                <div>
                    {!! Form::button( trans('laravel-user-module::auth.reset_password.submit'), [
                        'class' => 'btn btn-default submit',
                        'type' => 'submit'
                    ]) !!}
                    <a class="reset_pass" href="{!! route('getLogin') !!}">
                        {!! trans('laravel-user-module::auth.reset_password.login') !!}
                    </a>
                </div>
                <div class="clearfix"></div>
                <div class="separator">
                    @include('laravel-user-module::auth.auth_footer')
                </div>
            {!! Form::close() !!}
        </section>
    </div>
@endsection