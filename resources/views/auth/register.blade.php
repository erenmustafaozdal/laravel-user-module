@extends(config('laravel-user-module.views.auth.layout'))

@section('title')
    {!! trans('laravel-user-module::auth.register.title') !!}
@stop

@section('content')
    {{-- Register Form --}}
    <div class="form">
        <section class="login_content">
            {!! Form::open([
                'method' => 'POST',
                'url' => route('postRegister')
            ]) !!}
                <h1>{!! trans('laravel-user-module::auth.register.title') !!}</h1>
                {{-- Error Messages --}}
                @include('laravel-user-module::global.error_message')
                <div>
                    {!! Form::text( 'first_name', null, [
                        'class' => 'form-control',
                        'placeholder' => trans('laravel-user-module::auth.register.first_name'),
                        'value' => old('first_name')
                    ]) !!}
                </div>
                <div>
                    {!! Form::text( 'last_name', null, [
                        'class' => 'form-control',
                        'placeholder' => trans('laravel-user-module::auth.register.last_name'),
                        'value' => old('last_name')
                    ]) !!}
                </div>
                <div>
                    {!! Form::email( 'email', null, [
                        'class' => 'form-control',
                        'placeholder' => trans('laravel-user-module::auth.register.email'),
                        'value' => old('email')
                    ]) !!}
                </div>
                <div>
                    {!! Form::password( 'password', [
                        'class' => 'form-control',
                        'placeholder' => trans('laravel-user-module::auth.register.password')
                    ]) !!}
                </div>
                <div>
                    {!! Form::password( 'password_confirmation', [
                        'class' => 'form-control',
                        'placeholder' => trans('laravel-user-module::auth.register.password_confirmation')
                    ]) !!}
                </div>
                <div>
                    {!! Form::button( trans('laravel-user-module::auth.register.submit'), [
                        'class' => 'btn btn-default submit',
                        'type' => 'submit'
                    ]) !!}
                </div>
                <div class="clearfix"></div>
                <div class="separator">

                    <p class="change_link">
                        {!! trans('laravel-user-module::auth.register.login_message') !!}
                        <a href="{!! route('getLogin') !!}" class="to_register">
                            {!! trans('laravel-user-module::auth.register.login') !!}
                        </a>
                    </p>
                    <div class="clearfix"></div>
                    @include('laravel-user-module::auth.auth_footer')
                </div>
            {!! Form::close() !!}
        </section>
    </div>
@endsection