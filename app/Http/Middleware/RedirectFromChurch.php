<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectFromChurch
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $user = auth()->user();
        $ministry = $request->ministry;
        $event = $request->event;
        $church = $request->church;

        if(in_array($user->role, ['church_member', 'follow_up'])) {
            return redirect()->route('churches.contacts', [$ministry, $event, $church]);
        }
        return $next($request);
    }
}
