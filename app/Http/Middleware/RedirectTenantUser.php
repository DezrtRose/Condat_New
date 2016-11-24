<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class RedirectTenantUser {



    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;
    protected $request;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Request $request, Guard $auth)
    {
        $this->auth = $auth;
        $this->request = $request;
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
                $tenant_id = $this->request->segment(1);
                return redirect()->route('tenant.login', $tenant_id);
                //return tenant()->route('tenant.login', [$tenant_id]);
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
