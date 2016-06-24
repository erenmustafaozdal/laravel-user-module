<?php

namespace ErenMustafaOzdal\LaravelUserModule\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use App\Role;

use ErenMustafaOzdal\LaravelModulesBase\Controllers\AdminBaseController;
use ErenMustafaOzdal\LaravelModulesBase\Repositories\FileRepository;
// requests
use ErenMustafaOzdal\LaravelUserModule\Http\Requests\User\StoreRequest;
use ErenMustafaOzdal\LaravelUserModule\Http\Requests\User\UpdateRequest;
use ErenMustafaOzdal\LaravelUserModule\Http\Requests\User\PhotoRequest;


class RoleApiController extends AdminBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return Datatables
     */
    public function index(Request $request)
    {
        $users = Role::select(['id','name','slug','created_at']);
        // if is filter action
        if ($request->has('action') && $request->input('action') === 'filter') {
            $users->filter($request);
        }

        $addColumns = [];
        $editColumns = [
            'created_at'        => function($model) { return $model->created_at_table; }
        ];
        $removeColumns = [];
        return $this->getDatatables($users, $addColumns, $editColumns, $removeColumns);
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
        $user = User::where('id',$id)->with('roles')->select(['id','email','last_login','updated_at']);

        $editColumns = [
            'roles'         => function($model) { return $model->roles->implode('name', ', '); },
            'last_login'    => function($model) { return $model->last_login_table; },
            'updated_at'    => function($model) { return $model->updated_at_table; }
        ];
        $removeColumns = ['is_active', 'first_name', 'last_name'];
        return $this->getDatatables($user, [], $editColumns, $removeColumns);
    }

    /**
     * get user data for edit
     *
     * @param User $user
     * @param Request $request
     * @return Datatables
     */
    public function userForFastEdit(User $user, Request $request)
    {
        return $user;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        return $this->storeModel(User::class, $request);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  User $user
     * @param  UpdateRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, User $user)
    {
        $result = $this->updateModel($user, $request);
        $request->has('is_active') ? $this->activationComplete($this->model) : $this->activationRemove($this->model);
        return $result;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if ($user->id != Sentinel::getUser()->id) {
            return $this->destroyModel($user);
        } else {
            return response()->json(['result' => 'self']);
        }
    }

    /**
     * activate user
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function activate(User $user)
    {
        if ($this->activationComplete($user)) {
            return response()->json(['result' => 'success']);
        }
        return response()->json(['result' => 'error']);
    }

    /**
     * not activate user
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function notActivate(User $user)
    {
        if ($this->activationRemove($user)) {
            return response()->json(['result' => 'success']);
        }
        return response()->json(['result' => 'error']);
    }

    /**
     * group action method
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function group(Request $request)
    {
        $action = camel_case($request->input('action')) . 'GroupAction';
        if ( $this->$action(User::class, $request->input('id')) ) {
            return response()->json(['result' => 'success']);
        }
        return response()->json(['result' => 'error']);
    }

    /**
     * destroy photo for this user
     *
     * @param FileRepository $file
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function destroyAvatar(FileRepository $file, Request $request, User $user)
    {
        $file->deleteDirectory(config('laravel-user-module.user.uploads.path') . "/{$user->id}");
        $user->photo = NULL;
        if ( $user->save() ) {
            return response()->json(['result' => 'success']);
        }
        return response()->json(['result' => 'error']);
    }

    /**
     * upload photo for this user
     *
     * @param PhotoRequest $request
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function avatarPhoto(PhotoRequest $request, User $user)
    {
        return $this->updateModel($user, $request, config('laravel-user-module.user.uploads'));
    }
}
