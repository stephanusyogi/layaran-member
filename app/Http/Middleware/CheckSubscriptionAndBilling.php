<?php

namespace App\Http\Middleware;

use App\Models\Billing;
use App\Models\Membership;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSubscriptionAndBilling
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()->role !== 'member') {
            return $next($request);
        }

        $currentRouteName = $request->route()->getName();

        $membership = Membership::where('user_id', $request->user()->user_id)->first();
        if (!$membership || ($membership && $membership->status === 'expired')) {
            if ($currentRouteName !== 'manage_subscriptions') {
                return redirect()->route('manage_subscriptions')
                    ->with('error', 'Your subscription was not found or has expired. Please update your subscription to continue.');
            }
        }
        $billing = null;
        if ($membership) {
            $billing = Billing::where('membership_id', $membership->id)
                ->where('status', '!=', 'paid')
                ->latest('date')
                ->first();
        }
        
        if ($billing && $currentRouteName !== 'billings') {
            return redirect()->route('billings')
                ->with('error', 'There is an outstanding billing issue. Please review your billing details.');
        }

        return $next($request);
    }
}
