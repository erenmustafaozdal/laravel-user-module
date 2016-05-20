@extends(config('laravel-user-module.views.user.layout'))

@section('title')
    {!! trans('laravel-user-module::admin.user.index') !!}
@endsection

@section('page-title')
    <h1>{!! trans('laravel-user-module::admin.user.index') !!}
        <small>{!! trans('laravel-user-module::admin.user.index_description') !!}</small>
    </h1>
@endsection

@section('css')
    @parent
    {!! Html::style('vendor/laravel-modules-core/assets/global/plugins/datatables/datatables.min.css') !!}
    {!! Html::style('vendor/laravel-modules-core/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') !!}
    {!! Html::style('vendor/laravel-modules-core/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') !!}
@endsection

@section('script')
    @parent
    <script type="text/javascript">
        var datatableJs = "{!! lmcElixir('assets/app/datatable.js') !!}";
        var ajaxURL = "{!! route('api.user.index') !!}";
        $script.ready('app_datatable', function()
        {
            $script("{!! lmcElixir('assets/pages/scripts/user/index.js') !!}",'index');
        });
        $script.ready(['config','index'], function()
        {
            Index.init();
        });
    </script>
    <script src="{!! lmcElixir('assets/pages/js/loaders/admin-index.js') !!}"></script>
@endsection

@section('content')
    {{-- Table Portlet --}}
    <div class="portlet light portlet-fit portlet-datatable bordered">
        {{-- Table Portlet Title and Actions --}}
        <div class="portlet-title">
            <div class="caption">
                <i class="icon-users font-red"></i>
                <span class="caption-subject font-red sbold uppercase">
                    {!! trans('laravel-user-module::admin.user.index') !!}
                </span>
            </div>
            <div class="actions">
                <div class="btn-group">
                    <a id="sample_editable_1_new" class="btn green" href="{!! route('admin.user.create') !!}">
                        {!! trans('laravel-modules-core::admin.ops.add') !!}
                        <i class="fa fa-plus"></i>
                    </a>
                </div>
            </div>
        </div>
        {{-- /Table Portlet Title and Actions --}}

        {{-- Table Portlet Body --}}
        <div class="portlet-body">
            <div class="table-container">
                {{-- Table Actions --}}
                <div class="table-actions-wrapper">
                    <span> </span>
                    <select class="table-group-action-input form-control input-inline input-small input-sm">
                        <option value="">{!! trans('laravel-user-module::admin.ops.select') !!}</option>
                        <option value="activate">{!! trans('laravel-user-module::admin.ops.activate') !!}</option>
                        <option value="not_activate">{!! trans('laravel-user-module::admin.ops.not_activate') !!}</option>
                        <option value="destroy">{!! trans('laravel-user-module::admin.ops.destroy') !!}</option>
                    </select>
                    <button class="btn btn-sm green table-group-action-submit">
                        <i class="fa fa-check"></i> {!! trans('laravel-user-module::admin.ops.submit') !!}</button>
                </div>
                {{-- /Table Actions --}}

                {{-- DataTable --}}
                <table class="table table-striped table-bordered table-hover table-checkable lmcDataTable">
                    <thead>
                        <tr role="row" class="heading">
                            <th width="2%"> <input type="checkbox" class="group-checkable"> </th>
                            <th width="5%"> {!! trans('laravel-user-module::admin.fields.user.id') !!} </th>
                            <th width="5%"> {!! trans('laravel-user-module::admin.fields.user.photo') !!} </th>
                            <th width="100"> {!! trans('laravel-user-module::admin.fields.user.first_name') !!} </th>
                            <th width="10%"> {!! trans('laravel-user-module::admin.fields.user.status') !!} </th>
                            <th width="20%"> {!! trans('laravel-user-module::admin.fields.user.created_at') !!} </th>
                            <th width="10%"> {!! trans('laravel-user-module::admin.ops.action') !!} </th>
                        </tr>
                        <tr role="row" class="filter">
                            <td> </td>
                            <td>
                                <input type="text" class="form-control form-filter input-sm" name="id" placeholder="{!! trans('laravel-user-module::admin.fields.user.id') !!}">
                            </td>
                            <td> </td>
                            <td>
                                <input type="text" class="form-control form-filter input-sm" name="first_name" placeholder="{!! trans('laravel-user-module::admin.fields.user.first_name') !!} - {!! trans('laravel-user-module::admin.fields.user.last_name') !!}">
                            </td>
                            <td>
                                <select name="status" class="form-control form-filter input-sm">
                                    <option value="">{!! trans('laravel-user-module::admin.ops.select') !!}</option>
                                    <option value="1">{!! trans('laravel-user-module::admin.fields.user.active') !!}</option>
                                    <option value="0">{!! trans('laravel-user-module::admin.fields.user.not_active') !!}</option>
                                </select>
                            </td>
                            <td>
                                <div class="input-group date date-picker margin-bottom-5" data-date-format="dd/mm/yyyy">
                                    <input type="text" class="form-control form-filter input-sm" readonly name="created_at_from" placeholder="{!! trans('laravel-user-module::admin.ops.date_from') !!}">
                                        <span class="input-group-btn">
                                            <button class="btn btn-sm default" type="button">
                                                <i class="fa fa-calendar"></i>
                                            </button>
                                        </span>
                                </div>
                                <div class="input-group date date-picker" data-date-format="dd/mm/yyyy">
                                    <input type="text" class="form-control form-filter input-sm" readonly name="created_at_to" placeholder="{!! trans('laravel-user-module::admin.ops.date_to') !!}">
                                        <span class="input-group-btn">
                                            <button class="btn btn-sm default" type="button">
                                                <i class="fa fa-calendar"></i>
                                            </button>
                                        </span>
                                </div>
                            </td>
                            <td>
                                <div class="margin-bottom-5">
                                    <button class="btn btn-sm green btn-outline filter-submit margin-bottom">
                                        <i class="fa fa-search"></i>
                                        {!! trans('laravel-user-module::admin.ops.search') !!}
                                    </button>
                                </div>
                                <button class="btn btn-sm red btn-outline filter-cancel">
                                    <i class="fa fa-times"></i>
                                    {!! trans('laravel-user-module::admin.ops.reset') !!}
                                </button>
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                {{-- /DataTable --}}
            </div>
        </div>
        {{-- /Table Portlet Body --}}
    </div>
    {{-- /Table Portlet --}}
@endsection
