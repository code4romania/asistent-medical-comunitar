<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class FixMissingPasswordSetAtAttribute
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Can't do anything if we're not using the database session driver.
        if (config('session.driver') !== 'database') {
            return $next($request);
        }

        // Don't need to do anything if attribute is already set.
        if ($request->user()->hasSetPassword()) {
            return $next($request);
        }

        // If the user has recent sessions, then we can safely assume they have
        // set their password, so we'll mark it as such.
        if ($this->hasSessions($request->user())) {
            $request->user()
                ->markPasswordAsSet()
                ->save();
        }

        return $next($request);
    }

    private function hasSessions(User $user): bool
    {
        return DB::connection(config('session.connection'))
            ->table(config('session.table', 'sessions'))
            ->where('user_id', $user->getAuthIdentifier())
            ->exists();
    }
}
