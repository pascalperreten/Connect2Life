<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectFromEvent
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $ministry = $request->ministry;
        $user = auth()->user();
        if($user->church !== null) {
            if ($user->church->street === '' ){
                return redirect()->route('churches.manage', [$ministry, $user->church->events()->first(), $user->church]);
            } else {
                return redirect()->route('churches.show', [$ministry, $user->church->events()->first(), $user->church]);
            }
        }
        return $next($request);
    }
}
