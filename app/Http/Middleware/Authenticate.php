<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    public function handle($request, Closure $next, $role)
    {
        if(! Auth::check()) {
            return redirect()->route('login');
        }
        $authUser = auth()->user();
        // Auth
        if ($role == 'auth' && Auth::check() ) {
            return $next($request);
        }

        // Owner
        if ($role == 'owner' && ($request->user == Auth::id() || $authUser->role == 'admin' )) {
            return $next($request);
        }
        // Admin
        if ($role == 'admin' &&  $authUser->role == 'admin' ) {
            return $next($request);
        }

        return abort(404);

    }
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)    {
        return redirect()->back();
    }
}
