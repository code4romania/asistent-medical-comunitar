<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Filament\Resources\Profiles\ProfileResource;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasCompletedProfile
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        $onboardUrl = ProfileResource::getUrl('onboard');

        if (
            ! $user->isNurseOrMediator() ||
            $user->hasCompletedProfile() ||
            $onboardUrl === $request->getUri()
        ) {
            return $next($request);
        }

        return redirect()->to($onboardUrl);
    }
}
