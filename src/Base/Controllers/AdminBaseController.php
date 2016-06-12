<?php

namespace ErenMustafaOzdal\LaravelUserModule\Base\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Facades\Datatables;
use Laracasts\Flash\Flash;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use DB;
use App\User;

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
// exceptions
use ErenMustafaOzdal\LaravelUserModule\Exceptions\StoreException;
use ErenMustafaOzdal\LaravelUserModule\Exceptions\UpdateException;
use ErenMustafaOzdal\LaravelUserModule\Exceptions\DestroyException;
use ErenMustafaOzdal\LaravelUserModule\Exceptions\Auth\ActivateException;


abstract class AdminBaseController extends Controller
{
    /**
     * DataTables
     *
     * @var Datatables
     */
    protected $dataTables;

    /**
     * Model name
     *
     * @var string
     */
    protected $model = "";

    /**
     * AdminBaseController constructor.
     */
    public function __construct()
    {
        $this->model = $this->getModel();
    }

    /**
     * get Datatables
     *
     * @param query $query
     * @param array $addColumns
     * @param array $editColumns
     * @param array $removeColumns
     */
    public function getDatatables($query, $addColumns = [], $editColumns = [], $removeColumns = [])
    {
        $this->dataTables = Datatables::of($query);

        // add new urls
        $addUrls = array_has($addColumns, 'addUrls') ? array_pull($addColumns, 'addUrls') : [];
        $this->dataTables->addColumn('urls', function($model) use($addUrls)
        {
            $urls = [
                'details'   => route('api.user.detail', ['id' => $model->id]),
                'fast_edit' => route('api.user.fast_edit', ['id' => $model->id]),
                'show'      => route('admin.user.show', ['id' => $model->id]),
                'edit'      => route('api.user.update', ['id' => $model->id]),
                'destroy'   => route('api.user.destroy', ['id' => $model->id]),
            ];
            foreach($addUrls as $key => $value){
                if (isset($value['id']) && $value['id']) {
                    $urls[$key] = route($value['route'], ['id' => $model->id]);
                    continue;
                }
                $urls[$key] = route($value['route']);
            }
            return $urls;
        });

        // add columns
        $this->setColumns($addColumns,'add');
        // edit columns
        $this->setColumns($editColumns,'edit');
        // remove columns
        $this->setColumns($removeColumns,'remove');

        return $this->dataTables->addColumn('check_id', '{{ $id }}')->make(true);
    }

    /**
     * set data table columns
     *
     * @param array $columns
     * @param string $type => add|edit|remove
     */
    private function setColumns($columns, $type)
    {
        switch($type) {
            case 'add':
                foreach($columns as $key => $value) {
                    $this->dataTables->addColumn($key, $value);
                }
                break;
            case 'edit':
                foreach($columns as $key => $value) {
                    $this->dataTables->editColumn($key, $value);
                }
                break;
            case 'remove':
                foreach($columns as $value) {
                    $this->dataTables->removeColumn($value);
                }
                break;
        }
    }

    /**
     * store, flash success or error then redirect or return api result
     *
     * @param $class
     * @param $request
     * @param bool|false $imageColumn
     * @param string $path
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function storeModel($class, $request, $imageColumn = false, $path = 'index')
    {
        DB::beginTransaction();
        try {
            $model = $class::create($this->getData($request, $imageColumn));

            if ( ! isset($model->id)) {
                throw new StoreException($request->all());
            }

            // eğer üye kaydı ise ve is_active true var ise
            if ($class === 'App\User' && $request->has('is_active')) {
                $this->activationComplete($model);
            }

            event(new StoreSuccess($model));
            DB::commit();
            return response()->json(['result' => 'success']);
        } catch (StoreException $e) {
            DB::rollback();
            event(new StoreFail($e->getDatas()));
            return response()->json(['result' => 'error']);
        }
    }

    /**
     * update, flash success or error then redirect or return api result
     *
     * @param $model
     * @param $request
     * @param bool|false $imageColumn
     * @param string|null $path
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function updateModel($model, $request, $imageColumn = false, $path = null)
    {
        DB::beginTransaction();
        try {
            $model->fill($this->getData($request, $imageColumn));
            if ( ! $model->save()) {
                throw new UpdateException($model);
            }

            // eğer üye güncelleme ise is_active durumuna göre aktivasyon işlemi yap
            if ($model instanceof User) {
                $request->has('is_active') ? $this->activationComplete($model) : $this->activationRemove($model);
            }

            event(new UpdateSuccess($model));
            DB::commit();

            if (is_null($path)) {
                return response()->json(['result' => 'success']);
            }
            Flash::success(lmcTrans('laravel-user-module/admin.flash.update_success'));
        } catch (UpdateException $e) {
            DB::rollback();
            event(new UpdateFail($e->getDatas()));

            if (is_null($path)) {
                return response()->json(['result' => 'error']);
            }
            Flash::error(lmcTrans('laravel-user-module/admin.flash.update_error'));
        } finally {
            return $this->redirectRoute($path, $model);
        }
    }

    /**
     * Delete and flash success or fail then redirect or return api result
     *
     * @param $model
     * @param string $path
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroyModel($model, $path = "index")
    {
        try {
            if ( ! $model->delete()) {
                throw new DestroyException($model);
            }

            event(new DestroySuccess($model));
            return response()->json(['result' => 'success']);
        } catch (DestroyException $e) {
            event(new DestroyFail($e->getDatas()));
            return response()->json(['result' => 'error']);
        }
    }

    /**
     * set activation complete
     *
     * @param $user
     * @return boolean
     */
    protected function activationComplete($user)
    {
        try {
            $activation = Activation::create($user);
            if ( ! Activation::complete($user, $activation->code)) {
                throw new ActivateException($user->id, $activation->code, 'fail');
            }
            $user->is_active = true;
            $user->save();
            event(new ActivateSuccess($user));
            return true;
        } catch (ActivateException $e) {
            event(new ActivateFail($e->getId(),$e->getActivationCode(), $e->getType()));
            return false;
        }
    }

    /**
     * activation remove
     *
     * @param $user
     * @return boolean
     */
    protected function activationRemove($user)
    {
        try {
            if ( ! $activation = Activation::completed($user)) {
                throw new ActivateException($user, $activation->code, 'not_completed');
            }
            if ( ! Activation::remove($user)) {
                throw new ActivateException($user, $activation->code, 'not_remove');
            }
            $user->is_active = false;
            $user->save();
            event(new ActivateRemove($user));
            return true;
        } catch (ActivateException $e) {
            event(new ActivateFail($e->getId(),$e->getActivationCode(), $e->getType()));
            return false;
        }
    }

    /**
     * activate group action
     *
     * @param $class
     * @param array $ids
     * @return boolean
     */
    protected function activateGroupAction($class, $ids)
    {
        $users = $class::whereIn('id', $ids)->get();
        foreach($users as $user) {
            $this->activationComplete($user);
        }
        return true;
    }

    /**
     * not activate group action
     *
     * @param $class
     * @param array $ids
     * @return boolean
     */
    protected function notActivateGroupAction($class, $ids)
    {
        $users = $class::whereIn('id', $ids)->get(['id']);
        foreach($users as $user) {
            $this->activationRemove($user);
        }
        return true;
    }

    /**
     * destroy group action
     *
     * @param $class
     * @param array $ids
     * @return boolean
     */
    protected function destroyGroupAction($class, $ids)
    {
        $result = $class::destroy($ids);
        if ( is_integer($result) && $result > 0) {
            return true;
        }
        return false;
    }

    /**
     * Upload the image and return the data
     *
     * @param $request
     * @param string $field
     * @return mixed
     */
    protected function uploadImage($request, $field)
    {
        $data = $request->except($field);
        if ($request->file($field)) {
            $file = $request->file($field);
            $request->file($field);
            $fileName = rename_file($file->getClientOriginalName(), $file->getClientOriginalExtension());
            $path = $this->getUploadPath($field);
            $move_path = public_path($path);
            $file->move($move_path, $fileName);
            $data[$field] = $path . $fileName;
        }
        return $data;
    }

    /**
     * Get model name
     * if isset the model parameter, then get it
     * if not then get the class name, strip "Controller" out
     *
     * @return string
     */
    protected function getModel()
    {
        return empty($this->model) ?
            explode('Controller', substr(strrchr(get_class($this), '\\'), 1))[0]  :
            $this->model;
    }

    /**
     * Get data, if image column is passed, upload it
     *
     * @param $request
     * @param $imageColumn
     * @return mixed
     */
    protected function getData($request, $imageColumn)
    {
        return $imageColumn === false ? $request->all() : $this->uploadImage($request, $imageColumn);
    }

    /**
     * return redirect url path
     *
     * @param string $path
     * @param boolean|false $model
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    protected function redirectRoute($path, $model = false)
    {
        if ($model) {
            return redirect( route($this->routePath($path), ['id' => $model->id]) );
        }
        return redirect( route($this->routePath($path)) );

    }


    /**
     * Returns route path as string
     *
     * @param string $path
     * @return string
     */
    public function routePath($path = "index")
    {
        return 'admin.' . snake_case($this->model) . '.' . $path;
    }
}
