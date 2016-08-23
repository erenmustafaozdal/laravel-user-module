<?php

namespace ErenMustafaOzdal\LaravelUserModule\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Sentinel;
use App\Role;

use ErenMustafaOzdal\LaravelModulesBase\Controllers\BaseController;
// events
use ErenMustafaOzdal\LaravelUserModule\Events\Role\StoreSuccess;
use ErenMustafaOzdal\LaravelUserModule\Events\Role\StoreFail;
use ErenMustafaOzdal\LaravelUserModule\Events\Role\UpdateSuccess;
use ErenMustafaOzdal\LaravelUserModule\Events\Role\UpdateFail;
use ErenMustafaOzdal\LaravelUserModule\Events\Role\DestroySuccess;
use ErenMustafaOzdal\LaravelUserModule\Events\Role\DestroyFail;
// requests
use ErenMustafaOzdal\LaravelUserModule\Http\Requests\Role\ApiStoreRequest;
use ErenMustafaOzdal\LaravelUserModule\Http\Requests\Role\ApiUpdateRequest;


class RoleApiController extends BaseController
{
    /**
     * default urls of the model
     *
     * @var array
     */
    private $urls = [
        'edit_page'     => ['route' => 'admin.role.edit', 'id' => true]
    ];

    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return Datatables
     */
    public function index(Request $request)
    {
        $roles = Role::select(['id','name','slug','created_at']);
        // if is filter action
        if ($request->has('action') && $request->input('action') === 'filter') {
            $roles->filter($request);
        }

        $addColumns = [
            'addUrls' => $this->urls
        ];
        $editColumns = [
            'created_at'        => function($model) { return $model->created_at_table; }
        ];
        $removeColumns = [];
        return $this->getDatatables($roles, $addColumns, $editColumns, $removeColumns);
    }

    /**
     * get detail
     *
     * @param integer $id
     * @param Request $request
     * @return Datatables
     */
    public function detail($id, Request $request)
    {
        $role = Role::where('id',$id)->select(['id','name','slug', 'created_at','updated_at']);

        $editColumns = [
            'created_at'    => function($model) { return $model->created_at_table; },
            'updated_at'    => function($model) { return $model->updated_at_table; }
        ];
        return $this->getDatatables($role, [], $editColumns, []);
    }

    /**
     * get model data for edit
     *
     * @param Role $role
     * @param Request $request
     * @return Datatables
     */
    public function fastEdit(Role $role, Request $request)
    {
        return $role;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ApiStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ApiStoreRequest $request)
    {
        $this->setEvents([
            'success'   => StoreSuccess::class,
            'fail'      => StoreFail::class
        ]);
        return $this->storeModel(Sentinel::getRoleRepository()->createModel());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Role $role
     * @param  ApiUpdateRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(ApiUpdateRequest $request, Role $role)
    {
        $this->setEvents([
            'success'   => UpdateSuccess::class,
            'fail'      => UpdateFail::class
        ]);
        return $this->updateModel($role);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $this->setEvents([
            'success'   => DestroySuccess::class,
            'fail'      => DestroyFail::class
        ]);
        return $this->destroyModel($role);
    }

    /**
     * group action method
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function group(Request $request)
    {
        if ( $this->groupAlias(Role::class) ) {
            return response()->json(['result' => 'success']);
        }
        return response()->json(['result' => 'error']);
    }

    /**
     * get roles with query
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function models(Request $request)
    {
        return Role::where('name', 'like', "%{$request->input('query')}%")
            ->orWhere('slug', 'like', "%{$request->input('query')}%")->get(['id','name']);
    }
}
