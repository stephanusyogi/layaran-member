<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MembershipController extends Controller
{
    public function manage_subscription(){
        $title_page = "Manage Subscriptions";
        
        return view('manage_subscription', compact('title_page'));
    }
}
