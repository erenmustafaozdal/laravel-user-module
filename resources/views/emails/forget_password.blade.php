{!! str_replace(
    [':name',':token'],
    [$user->first_name,$reminder->code],
    trans('laravel-user-module::auth.forget_password.mail_content'))
!!}