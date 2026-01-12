<?php

namespace App\Http\Middleware;

use App\Contracts\RequiresContract;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureContractApproved
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
            if ($entity instanceof RequiresContract) {
                $contract = $entity->contract;

                // Block if no contract or not approved
                if (!$contract || $contract->status !== 'approved') {
                    return redirect()->route('contract.pending');
                }
            }
    }

        return $next($request);
    }
}
