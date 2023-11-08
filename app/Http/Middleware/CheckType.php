<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        
        if($request->user()->type==1&&Str::contains($request->getRequestUri(),'/clients')){ //FIXME: Controlar que no se pueda acceder a ninguna otra ruta que no sean las establecidas
            
            return $next($request);
        }
        if($request->user()->type==0&&$request->getRequestUri()==='/backoffice'){
            return $next($request);
        }
        return redirect('/');
    }
}
