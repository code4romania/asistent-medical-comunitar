<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Filament\Resources\ProfileResource;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasCompletedProfile
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $onboardUrl = ProfileResource::getUrl('onboard');

        if (
            Auth::user()->hasCompletedProfile() ||
            $onboardUrl === $request->getUri()
        ) {
            return $next($request);
        }

        return redirect()->to($onboardUrl);
    }
}
