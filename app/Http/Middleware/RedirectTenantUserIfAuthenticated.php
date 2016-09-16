<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class RedirectTenantUserIfAuthenticated {



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

       // check for valid tenant
        $this->validateTenant();

        if ($this->auth->check())
        {
            return tenant()->route('tenant.index');
        }
        //redirect to setup page if tenant has not completed setup

		return $next($request);
	}

    function validateTenant()
    {
        $tenant =\App::make('App\Condat\Libraries\Tenant');
        $tenant->authenticateTenant();
    }

}
