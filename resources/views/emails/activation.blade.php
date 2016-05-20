{!! str_replace(
    [':name',':id',':code'],
    [$user->first_name,$user->id,$activation->code],
    trans('laravel-user-module::auth.activation.mail_content'))
!!}