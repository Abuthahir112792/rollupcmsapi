<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
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
        if (Auth::guard($guard)->check()) {
            if(Auth::user()->role == 'shop_keeper'){
                return redirect()->route('admin.home');
            } else{
                Auth::logout();
                return redirect()->route('admin.login');
            }
        }

        else if (Auth::guard($guard)->check()) {
            if(Auth::user()->role == 'branch_user'){
                return redirect()->route('branch.home');
            } else{
                Auth::logout();
                return redirect()->route('branch.login');
            }
        }
        return $next($request);
    }
}
