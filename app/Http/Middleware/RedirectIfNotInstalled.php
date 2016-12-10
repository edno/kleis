<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use RachidLaasri\LaravelInstaller\Middleware\canInstall as canInstall;

class RedirectIfNotInstalled extends canInstall
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (!$this->alreadyInstalled()) {
            return redirect('/install');
        }

        return $next($request);
    }
}
