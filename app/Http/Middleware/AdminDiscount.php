<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Support\Facades\Session;
use Response;

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
            return Response::make(view('errors.403'), 403);
        }
        return $next($request);
    }
}
