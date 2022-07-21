<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
class RoleMiddleware
{

    public function handle($request, Closure $next, $role, $permission = null)
    {
        if(Auth::check()){
        if(!$request->user()->hasRole($role)) {

             abort(401);

        }

        if($permission !== null && !$request->user()->can($permission)) {

              abort(401);
        }
        }else{
            return redirect('/');
        }

        return $next($request);

    }
}