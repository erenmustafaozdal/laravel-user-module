<?php

namespace ErenMustafaOzdal\LaravelUserModule\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Sentinel;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use Laracasts\Flash\Flash;
use DB;
use App\User;

// requests
use ErenMustafaOzdal\LaravelUserModule\Http\Requests\Auth\RegisterRequest;
use ErenMustafaOzdal\LaravelUserModule\Http\Requests\Auth\LoginRequest;
// events
use ErenMustafaOzdal\LaravelUserModule\Events\Auth\RegisterSuccess;
use ErenMustafaOzdal\LaravelUserModule\Events\Auth\RegisterFail;
use ErenMustafaOzdal\LaravelUserModule\Events\Auth\ActivateSuccess;
use ErenMustafaOzdal\LaravelUserModule\Events\Auth\ActivateFail;
use ErenMustafaOzdal\LaravelUserModule\Events\Auth\LoginSuccess;
use ErenMustafaOzdal\LaravelUserModule\Events\Auth\LoginFail;
use ErenMustafaOzdal\LaravelUserModule\Events\Auth\SentinelNotActivated;
use ErenMustafaOzdal\LaravelUserModule\Events\Auth\SentinelThrottling;
use ErenMustafaOzdal\LaravelUserModule\Events\Auth\Logout;
// exceptions
use ErenMustafaOzdal\LaravelUserModule\Exceptions\Auth\RegisterException;
use ErenMustafaOzdal\LaravelUserModule\Exceptions\Auth\ActivateException;
use ErenMustafaOzdal\LaravelUserModule\Exceptions\Auth\LoginException;

class AuthController extends Controller
{
    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    protected $redirectPath;
    protected $loginPath;

    /**
     * Create a new authentication controller instance.
     *
     * @return mixed
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
        $this->redirectPath = config('laravel-user-module.redirect_route');
        $this->loginPath = config('laravel-user-module.login_route');
    }

    /**
     * get login metod
     */
    public function getLogin()
    {
        return view(config('laravel-user-module.views.auth.login'));
    }

    /**
     * post login metod
     *
     * @param   LoginRequest        $request
     * @return  Redirector
     */
    public function postLogin(LoginRequest $request)
    {
        try {
            $credentials = $request->only(['email', 'password']);
            $user = Sentinel::authenticate($credentials, $request->has('remember'));

            if ( ! isset($user->id)) {
                throw new LoginException('');
            }

            // event fire
            event(new LoginSuccess($user));
            return redirect( lmbRoute(config('laravel-user-module.url.redirect_route')) );
        } catch (NotActivatedException $e) {
            // event fire
            event(new SentinelNotActivated($e));
        } catch (ThrottlingException $e) {
            // event fire
            event(new SentinelThrottling($e));
        } catch (LoginException $e) {
            Flash::error(trans('laravel-user-module::auth.login.fail'));
        }

        // event fire
        event(new LoginFail($request->except('_token')));
        return redirect(lmbRoute('getLogin'))->withInput();
    }

    /**
     * get logout metod
     */
    public function getLogout()
    {
        $user = Sentinel::getUser();
        Sentinel::logout(null, true);
        // event fire
        event(new Logout($user));
        return redirect(lmbRoute('getLogin'));
    }

    /**
     * get register metod
     */
    public function getRegister()
    {
        return view(config('laravel-user-module.views.auth.register'));
    }

    /**
     * post register metod
     *
     * @param   RegisterRequest     $request
     * @return  Redirector
     */
    public function postRegister(RegisterRequest $request)
    {
        $datas = $request->all();
        DB::beginTransaction();
        try {
            $user = User::create($datas);
            if ( ! isset($user->id)) {
                throw new RegisterException($datas);
            }

            // event fire
            event(new RegisterSuccess($user));

            Flash::success(trans('laravel-user-module::auth.register.success', [ 'email' => $user->email]));
            DB::commit();
            return redirect(lmbRoute('getLogin'));
        } catch (RegisterException $e) {
            DB::rollback();
            Flash::error(trans('laravel-user-module::auth.register.fail'));
            // event fire
            event(new RegisterFail($e->getDatas()));
            return redirect(lmbRoute('getRegister'))->withInput();
        }
    }

    /**
     * get account activate metod
     *
     * @param   integer     $id
     * @param   string      $code
     * @return  Redirector
     */
    public function accountActivate($id, $code)
    {
        try {
            $user = Sentinel::findById($id);

            if ( is_null($user) || ! Activation::exists($user) ) {
                throw new ActivateException($id, $code, 'not_found');
            }
            if ( ! Activation::complete($user, $code)) {
                throw new ActivateException($id, $code, 'fail');
            }

            $user->is_active = true;
            $user->save();
            Sentinel::login($user);
            Flash::success(trans('laravel-user-module::auth.activation.success'));
            // event fire
            event(new ActivateSuccess($user));
            return redirect(lmbRoute(config('laravel-user-module.url.redirect_route')));
        } catch (ActivateException $e) {
            Flash::error(trans('laravel-user-module::auth.activation.'.$e->getType()));
            // event fire
            event(new ActivateFail($e->getId(),$e->getActivationCode(), $e->getType()));
            return redirect(lmbRoute('getLogin'));
        }
    }
}
