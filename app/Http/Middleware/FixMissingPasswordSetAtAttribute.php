<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class FixMissingPasswordSetAtAttribute
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // If the user got here, it's pretty clear they have
        // set their password, so we'll mark it as such.
        if (! Auth::user()->hasSetPassword()) {
            Auth::user()
                ->markPasswordAsSet()
                ->save();
        }

        return $next($request);
    }
}
