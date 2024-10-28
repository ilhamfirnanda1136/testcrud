<?php

namespace App\Http\Middleware;

use Closure,Auth;
use Illuminate\Http\Request;

class level
{
    public function handle(Request $request, Closure $next,...$level)
    {
        if(in_array($request->user()->level,$level))
        {
            return $next($request);
        }
       return  redirect('/');
    }
}
