<?php

namespace ErenMustafaOzdal\LaravelUserModule\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Sentinel;

class RedirectIfAuthenticated
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Sentinel::check();
        if ( isset($user->id) ) {
            return redirect(route(config('laravel-user-module.url.redirect_route')));
        }

        return $next($request);
    }
}
