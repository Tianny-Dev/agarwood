<?php

namespace App\Http\Middleware\Agent;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureAgentIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (!$user || !$user->agent || !$user->agent->is_verified) {
            return redirect()->route('agent.verification.notice')
                ->with('error', 'Your agent account is not verified.');

            // Abort with 403
            // return abort(403, 'Your agent account is not verified.');
        }
        
        return $next($request);
    }
}
