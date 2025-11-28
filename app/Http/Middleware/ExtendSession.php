<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cookie;

class ExtendSession
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

        $encryptedTrustedDeviceCookie = Cookie::get(COOKIE_TRUSTED_DEVICE);
        if(!isset($encryptedTrustedDeviceCookie)){
            config(['session.lifetime' => SESSION_LIFETIME_UNTRUSTED_DEVICE_MINUTES]);
            return $next($request);
        }

        //it's a trusted device so it has it's own unique device session
        config(['session.lifetime' => SESSION_LIFETIME_TRUSTED_DEVICE_MINUTES]);
        return $next($request);

    }
}
