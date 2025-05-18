<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureOrganizationAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $user = Auth::user();
        $orgSlug = $request->route('organization');
        // dd($user->organization->slug, $orgSlug);

        if ($user->role !== User::ROLE['admin'] || (!$user->organization || $user->organization->slug !== $orgSlug)) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        return $next($request);
    }
}
