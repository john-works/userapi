<?php

namespace App\Http\Middleware;

use app\Helpers\AppConstants;
use app\Helpers\Security;
use Closure;

class RedirectIfNotHr
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
        $user = session(Security::$SESSION_USER);
        if ($user == null) {
            return redirect('/');
        }elseif ($user->roleCode != AppConstants::$ROLE_CODE_HUMAN_RESOURCE){
            return  redirect(route('users.profile'));
        }

        /*
         * Else we proceed with what we want to access
         * */
        return $next($request);

    }
}
