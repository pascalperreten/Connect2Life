<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Ministry;
use Symfony\Component\HttpFoundation\Response;

class EnsureCorrectMinistry
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $ministry = $request->route('ministry');
        $user = auth()->user();

        // If route has no ministry, let it pass
        if (!$ministry) {
            abort(404);
        }

        if ($user && $user->ministry->id !== $ministry->id) {
            abort(404);
        }

        return $next($request);
    }
}
