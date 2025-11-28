<?php

namespace App\Http\Middleware;

use app\ApiResp;
use app\Helpers\Security;
use Closure;
use Illuminate\Support\Facades\Cookie;

class AuthorizedUserAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {


        /*
         * If the token is not set we redirect to the home page
         * */
        if (Cookie::get(Security::$COOKIE_TOKEN) == null || session(Security::$SESSION_USER) == null) {

            if ($request->is('api/*') || $request->wantsJson() ||$request->expectsJson() || $request->ajax())
            {
                /*
                 * if it's a json request return Json
                 * */
                $msg = "Your session has expired, Please login again and retry";
                return response()->json($msg);
            }

            /*
             * redirect to login page
             * */
            return redirect(route('login'));

        }

        /*
         * Else we proceed with what we want to access
         * */
        return $next($request);

    }

}
