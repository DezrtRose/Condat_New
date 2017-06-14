<?php namespace App\Http\Middleware;

use App\Modules\Agency\Models\AgencySubscription;
use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class StandardFeatures
{


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
     * @param  Guard $auth
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
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $tenant_id = $request->tenant_id;
        $agency_subscription = AgencySubscription::where('agency_id', '=', $tenant_id)->where('is_current', '=', 1)->first();

        if ($agency_subscription->subscription_status_id != 2) {
            //return response('Unauthorized.', 401);
            abort(401, 'Unauthorized action.');
        }

        return $next($request);
    }
}
