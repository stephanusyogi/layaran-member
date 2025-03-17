<?php

namespace App\Http\Middleware;

use App\Models\Billing;
use App\Models\Membership;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Redirect;

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
        
        $billing = Billing::where('user_id', $request->user()->user_id)->first();
        
        if (!$membership && !$billing) {
            if ($currentRouteName !== 'manage_subscriptions') {
                return redirect()->route('manage_subscriptions')
                    ->with('error', 'Your subscription was not found or has no active billing. Please update your subscription to continue.');
            }
        }
        
        if ($membership && $membership->status === 'expired') {
            if ($currentRouteName !== 'manage_subscriptions') {
                return redirect()->route('manage_subscriptions')
                    ->with('error', 'Your subscription has expired. Please update your subscription to continue.');
            }
        }

        return $next($request);
    }

}
