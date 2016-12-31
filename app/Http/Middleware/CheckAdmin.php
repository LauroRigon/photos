<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckAdmin
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
        if(Auth::check() && Auth::user()->isAdmin){
            return $next($request);
        }else{
            if($request->ajax()){
                return response([
                    'status' => 'error',
                    'msg' => "Acesso não autorizado!"
                ]);
            }
            return redirect('/home');
        }

    }
}
