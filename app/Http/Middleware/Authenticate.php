<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Session;

class Authenticate
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
        if ($this->auth->guest()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                preg_match('!\d+!', $_COOKIE['database_name'], $tenant_id);
                unset($_COOKIE['database_name']);
                unset($_COOKIE['paypal_payment_data']);
                setcookie('database_name', null, -1, '/');
                setcookie('paypal_payment_data', null, -1, '/');
                $this->auth->logout();
                Session::flush();
                return redirect()->guest($tenant_id[0] . '/login');
            }
        }

        return $next($request);
    }
}
