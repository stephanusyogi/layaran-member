<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request){
        $title_page = "My Dashboard";
        return view('dashboard', compact('title_page'));
    }
}
