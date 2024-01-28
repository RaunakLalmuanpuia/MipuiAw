<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsSuperAdmin
{

    public function handle(Request $request, Closure $next): Response
    {
        //CHECK IF SUPER ADMIN
        if(Auth::check() && Auth::user()->role_id==1 ||Auth::check() && Auth::user()->role_id==2){

            return $next($request);
        }
        return back();
    }
}
