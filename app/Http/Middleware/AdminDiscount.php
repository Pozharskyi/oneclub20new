<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Support\Facades\Session;

class AdminDiscount
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
        if(! Auth::user()->hasRoles(['СуперАдмин', 'Маркетинг'])){
            Session::flash('message', 'Нет прав доступа');
            return back();
        }
        return $next($request);
    }
}
