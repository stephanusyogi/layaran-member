<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BillingController extends Controller
{
    public function billing(){
        $title_page = "My Invoices";
        
        return view('manage_subscription', compact('title_page'));
    }
}
