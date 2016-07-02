<?php

namespace ErenMustafaOzdal\LaravelUserModule\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use App\User;

use ErenMustafaOzdal\LaravelModulesBase\Controllers\AdminBaseController;
use ErenMustafaOzdal\LaravelModulesBase\Repositories\FileRepository;
// events
use ErenMustafaOzdal\LaravelUserModule\Events\User\StoreSuccess;
use ErenMustafaOzdal\LaravelUserModule\Events\User\StoreFail;
use ErenMustafaOzdal\LaravelUserModule\Events\User\UpdateSuccess;
use ErenMustafaOzdal\LaravelUserModule\Events\User\UpdateFail;
use ErenMustafaOzdal\LaravelUserModule\Events\User\DestroySuccess;
use ErenMustafaOzdal\LaravelUserModule\Events\User\DestroyFail;
use ErenMustafaOzdal\LaravelUserModule\Events\Auth\ActivateSuccess;
use ErenMustafaOzdal\LaravelUserModule\Events\Auth\ActivateRemove;
use ErenMustafaOzdal\LaravelUserModule\Events\Auth\ActivateFail;
// requests
use ErenMustafaOzdal\LaravelUserModule\Http\Requests\User\StoreRequest;
use ErenMustafaOzdal\LaravelUserModule\Http\Requests\User\UpdateRequest;
use ErenMustafaOzdal\LaravelUserModule\Http\Requests\User\PhotoRequest;


class UserApiController extends AdminBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return Datatables
     */
    public function index(Request $request)
    {
        $this->authorize('indexApi', Sentinel::getUser());

        $users = User::select(['id','photo','first_name','last_name', 'is_active','created_at']);
        // if is filter action
        if ($request->has('action') && $request->input('action') === 'filter') {
            $users->filter($request);
        }

        $addColumns = [
            'addUrls' => [
                'activate'      => ['route' => 'api.user.activate', 'id' => true],
                'not_activate'  => ['route' => 'api.user.notActivate', 'id' => true],
                'edit_page'     => ['route' => 'admin.role.edit', 'id' => true]
            ],
            'status'            => function($model) { return $model->is_active; },
            'fullname'          => function($model) { return $model->fullname; },
        ];
        $editColumns = [
            'photo'             => function($model) { return $model->getPhoto([], 'smallest', true); },
            'created_at'        => function($model) { return $model->created_at_table; }
        ];
        $removeColumns = ['is_active', 'first_name', 'last_name'];
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
        $this->authorize('detailApi', $user->get()[0]);

        $editColumns = [
            'roles'         => function($model) { return $model->roles->implode('name', ', '); },
            'last_login'    => function($model) { return $model->last_login_table; },
            'updated_at'    => function($model) { return $model->updated_at_table; }
        ];
        $removeColumns = ['is_active', 'first_name', 'last_name'];
        return $this->getDatatables($user, [], $editColumns, $removeColumns);
    }

    /**
     * get model data for edit
     *
     * @param User $user
     * @param Request $request
     * @return Datatables
     */
    public function fastEdit(User $user, Request $request)
    {
        $this->authorize('fastEditApi', $user);
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
        $this->authorize('storeApi', Sentinel::getUser());
        return $this->storeModel(User::class, $request, [
            'success'           => StoreSuccess::class,
            'fail'              => StoreFail::class,
            'activationSuccess' => ActivateSuccess::class,
            'activationFail'    => ActivateFail::class
        ]);
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
        $this->authorize('updateApi', $user);
        $result = $this->updateModel($user, $request, [
            'success'   => UpdateSuccess::class,
            'fail'      => UpdateFail::class
        ]);

        // activation
        $request->has('is_active') ? $this->activationComplete($this->model, [
            'activationSuccess'     => ActivateSuccess::class,
            'activationFail'        => ActivateFail::class
        ]) : $this->activationRemove($this->model, [
            'activationRemove'      => ActivateRemove::class,
            'activationFail'        => ActivateFail::class
        ]);
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
        $this->authorize('destroyApi', $user);
        return $this->destroyModel($user, [
            'success'   => DestroySuccess::class,
            'fail'      => DestroyFail::class
        ]);
    }

    /**
     * activate user
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function activate(User $user)
    {
        $this->authorize('activateApi', $user);
        $result = $this->activationComplete($user, [
            'activationSuccess'     => ActivateSuccess::class,
            'activationFail'        => ActivateFail::class
        ]);
        if ($result) {
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
        $this->authorize('notActivateApi', $user);
        $result = $this->activationRemove($user, [
            'activationRemove'      => ActivateRemove::class,
            'activationFail'        => ActivateFail::class
        ]);
        if ($result) {
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
        $this->authorize('groupApi', Sentinel::getUser());
        $events = [];
        switch($request->input('action')) {
            case 'activate':
                $events['activationSuccess'] = ActivateSuccess::class;
                $events['activationFail'] = ActivateFail::class;
                break;
            case 'not_activate':
                $events['activationRemove'] = ActivateRemove::class;
                $events['activationFail'] = ActivateFail::class;
                break;
            case 'destroy':
                break;
        }
        $action = camel_case($request->input('action')) . 'GroupAction';
        if ( $this->$action(User::class, $request->input('id'), $events) ) {
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
        $this->authorize('destroyAvatarApi', $user);
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
        $this->authorize('avatarPhotoApi', $user);
        return $this->updateModel($user, $request, [
            'success'   => UpdateSuccess::class,
            'fail'      => UpdateFail::class
        ], config('laravel-user-module.user.uploads'));
    }
}
