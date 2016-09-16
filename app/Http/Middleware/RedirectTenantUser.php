<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class RedirectTenantUser {



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
        $this->validateTenant();
        //if ($this->auth->guest())
        if (auth()->guard('tenants')->guest())
        {
            if ($request->ajax())
            {
                return response('Unauthorized.', 401);
            }
            else
            {
                return tenant()->route('tenant.login');
            }
        }

		return $next($request);
	}

    function validateTenant()
    {
        $tenant =\App::make('App\Condat\Libraries\Tenant');
        $tenant->authenticateTenant();
    }
}
