{{-- menu footer buttons --}}
<div class="sidebar-footer hidden-small">
    <a>
        <span class="glyphicon"></span>
    </a>
    <a>
        <span class="glyphicon"></span>
    </a>
    <a href="{!! route('admin.user.show',['id'=>$auth_user->id]) !!}" data-toggle="tooltip" data-placement="top" title="{!! trans('laravel-user-module::admin.profile') !!}">
        <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
    </a>
    <a href="{!! route('getLogout') !!}" data-toggle="tooltip" data-placement="top" title="{!! trans('laravel-user-module::admin.logout') !!}">
        <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
    </a>
</div>
{{-- /menu footer buttons --}}