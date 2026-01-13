<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfContractPaid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        foreach ($user->contractableEntities() as $entity) {
            $contract = $entity->contract;

            // If paid, redirect away from pending page
            if ($contract && $contract->status === 'paid') {
                return redirect()->route('dashboard');
            }
        }

        return $next($request);
    }
}
