<?php

namespace ErenMustafaOzdal\LaravelUserModule\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class Authenticate
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new middleware instance.
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
        if ( ! Sentinel::check()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect(route('getLogin'));
            }
        }

        return $next($request);
    }
}