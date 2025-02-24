<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Billing;
use App\Models\Membership;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request){
        $title_page = "My Dashboard";

        $announcements = Announcement::where('published_at', '>=', Carbon::now()->subMonths(3))
            ->where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->take(15)
            ->get()
            ->map(function ($announcement) {
                $announcement->isNew = $announcement->published_at >= Carbon::now()->subDays(3);
                return $announcement;
            });

        return view('dashboard', compact('title_page', 'announcements'));
    }
}
