<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AdminMiddleware
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
        if (Auth::check()) {
            $role = Auth::user()->getRole();
            if ($role == 'administrator' || $role == 'costumer-service') {
                return $next($request);
            } else {
                return redirect('/')->withError('Akses tidak diizinkan');
            }
        } else {
            return redirect('/login');
        }
    }
}
