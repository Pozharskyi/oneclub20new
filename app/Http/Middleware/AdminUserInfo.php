<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Support\Facades\Session;

class AdminUserInfo
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
        if(! Auth::user()->hasRoles(['СуперАдмин', 'ЦОЗ'])){
            Session::flash('message', 'Нет прав доступа');
            return back();
        }
        return $next($request);
    }
}
