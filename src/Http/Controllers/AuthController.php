<?php

namespace ErenMustafaOzdal\LaravelUserModule\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    protected $redirectPath;
    protected $loginPath;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
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
        return view(config('laravel-user-module.views.login'));
    }

    /**
     * post login metod
     *
     * @param   Request     $request
     */
    public function postLogin(Request $request)
    {
        //
    }

    /**
     * get logout metod
     */
    public function getLogout()
    {
        //
    }

    /**
     * get register metod
     */
    public function getRegister()
    {
        return view(config('laravel-user-module.views.register'));
    }

    /**
     * post register metod
     *
     * @param   Request     $request
     */
    public function postRegister(Request $request)
    {
        //
    }

    /**
     * get account activate metod
     *
     * @param   integer     $id
     * @param   string      $code
     */
    public function accountActivate($id, $code)
    {
        //
    }
}
