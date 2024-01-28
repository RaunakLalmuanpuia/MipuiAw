<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckStateAndDepartmentNodalOfficer
{
 
    public function handle(Request $request, Closure $next): Response
    {
        //CHECK IF IT IS STATE AND DEPARTMENT NODAL & SUPER ADMIN
        if(Auth::user()->role_id==2 ||Auth::user()->role_id==3 ||Auth::user()->role_id==1){

            return $next($request);
        }
        return back();
    }
}
