<?php

namespace App\Http\Middleware;

use App\Models\Permission;
use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HasPermissionMiddleware
{
    protected $openRoutesNames = [
        'projects.index'
    ];
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        $routeName =request()->route()->getName();
        if (!auth()->user()->hasPermission(Permission::PERMISSIONS[$permission]) && !in_array($routeName, $this->openRoutesNames)) {
            throw new AuthorizationException;
        }

        return $next($request);
    }
}
