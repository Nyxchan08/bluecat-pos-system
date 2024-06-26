<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  array  ...$guards
     * @return mixed
     */
    public function handle($request, Closure $next, ...$guards)
    {
        $this->authenticate($request, $guards);

        if ($request->user() && !$this->authorize($request->user(), $request)) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }

    /**
     * Check if the authenticated user is authorized for the request.
     *
     * @param  \App\Models\User  $user
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function authorize($user, $request)
    {
        // Allow admin users unrestricted access
        if ($user->isAdmin()) {
            return true;
        }

        // Allow regular users access to specific routes
        if ($user->isUser()) {
            return $this->allowRegularUserAccess($request);
        }

        return false;
    }

    /**
     * Check if the regular user is allowed access to the current route.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function allowRegularUserAccess($request)
    {
        $allowedRoutes = [
            'store.index',   // Allow access to store.index
            'processLogout', // Allow access to processLogout
            'transactions.store',
            'transactions.index',
            'transactions.download',
            'transactions.preview',
            'transactions.destroy',


        ];

        return in_array($request->route()->getName(), $allowedRoutes);
    }

    /**
     * Redirect to the login page if the user is not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            return route('login'); // Adjust this to match your actual login route
        }
    }
}
