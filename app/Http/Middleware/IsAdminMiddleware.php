<?php

namespace App\Http\Middleware;

use DB;
use Closure;
use App\Role;
use Illuminate\Support\Facades\Auth;

class IsAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){

        // $pivot = DB::table('role_user')->select('role_id')->where('user_id', Auth::id())->first();
        // $role = Role::select('name')->where('id', $pivot->role_id)->first();
        // if (Auth::user() && $role->name == 'admin') {
        //     return $next($request);
        // }
        
        if(auth()->user()->hasRole('admin')){
            return $next($request);
        }

        return response()->make(view('errors.404'), 404);
    }
}
