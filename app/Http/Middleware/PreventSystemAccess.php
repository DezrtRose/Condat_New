<?php namespace App\Http\Middleware;

use Closure;

class PreventSystemAccess {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $host = $request->getHost();
        $parts = explode('.', $host);
        /*if (count($parts) > 2) {
            show_404();
        }*/

        return $next($request);

    }

}
