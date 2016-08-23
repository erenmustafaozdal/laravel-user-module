<?php

namespace ErenMustafaOzdal\LaravelUserModule\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Sentinel;
use App\User;

use ErenMustafaOzdal\LaravelModulesBase\Controllers\BaseUserController;
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
use ErenMustafaOzdal\LaravelUserModule\Http\Requests\User\ApiStoreRequest;
use ErenMustafaOzdal\LaravelUserModule\Http\Requests\User\ApiUpdateRequest;
use ErenMustafaOzdal\LaravelUserModule\Http\Requests\User\PhotoRequest;


class UserApiController extends BaseUserController
{
    /**
     * default urls of the model
     *
     * @var array
     */
    private $urls = [
        'activate'      => ['route' => 'api.user.activate', 'id' => true],
        'not_activate'  => ['route' => 'api.user.notActivate', 'id' => true],
        'edit_page'     => ['route' => 'admin.user.edit', 'id' => true]
    ];

    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return Datatables
     */
    public function index(Request $request)
    {
        $users = User::select(['id','photo','first_name','last_name', 'is_active','created_at']);
        // if is filter action
        if ($request->has('action') && $request->input('action') === 'filter') {
            $users->filter($request);
        }

        $addColumns = [
            'addUrls'       => $this->urls,
            'status'        => function($model) { return $model->is_active; },
            'fullname'      => function($model) { return $model->fullname; },
        ];
        $editColumns = [
            'photo'         => function($model) { return $model->getPhoto([], 'smallest', true); },
            'created_at'    => function($model) { return $model->created_at_table; }
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
        return $user;
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
            'success'           => StoreSuccess::class,
            'fail'              => StoreFail::class,
            'activationSuccess' => ActivateSuccess::class,
            'activationFail'    => ActivateFail::class
        ]);
        return $this->storeModel(User::class);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  User $user
     * @param  ApiUpdateRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(ApiUpdateRequest $request, User $user)
    {
        return $this->updateAlias($user,[
            'success'           => UpdateSuccess::class,
            'fail'              => UpdateFail::class,
            'activationSuccess' => ActivateSuccess::class,
            'activationFail'    => ActivateFail::class,
            'activationRemove'  => ActivateRemove::class
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $this->setEvents([
            'success'   => DestroySuccess::class,
            'fail'      => DestroyFail::class
        ]);
        $result =  $this->destroyModel($user);
        $file = new FileRepository(config('laravel-user-module.document.uploads'));
        $file->deleteDirectories($user);
        return $result;
    }

    /**
     * activate user
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function activate(User $user)
    {
        $this->setEvents([
            'activationSuccess'     => ActivateSuccess::class,
            'activationFail'        => ActivateFail::class
        ]);
        $this->setModel($user);
        $result = $this->activationComplete();
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
        $this->setEvents([
            'activationRemove'      => ActivateRemove::class,
            'activationFail'        => ActivateFail::class
        ]);
        $this->setModel($user);
        $result = $this->activationRemove();
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
        if ( $this->groupAlias(User::class) ) {
            return response()->json(['result' => 'success']);
        }
        return response()->json(['result' => 'error']);
    }

    /**
     * destroy photo for this user
     *
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function destroyAvatar(Request $request, User $user)
    {
        $this->setOperationRelation([
            [ 'relation_type'     => 'not', 'datas' => [ 'photo'    => NULL ] ]
        ]);
        $file = new FileRepository(config('laravel-user-module.user.uploads'));
        $file->deleteDirectories($user);
        return $this->updateAlias($user);
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
        $this->setFileOptions([config('laravel-user-module.user.uploads.photo')]);
        return $this->updateAlias($user);
    }
}
