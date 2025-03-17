<?php

namespace App\Http\Controllers;

use App\Models\Billing;
use App\Models\Membership;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MembershipController extends Controller
{
    public function manage_subscription(){
        $title_page = "Manage Subscriptions";
        $plans = Plan::with('billingCycles')->get();
        
        return view('manage_subscription', compact('title_page', 'plans'));
    }
    
}
