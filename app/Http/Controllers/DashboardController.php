<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Plan;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Basic Member Counts
        $totalMembers = Member::count();
        $activeMembers = Member::where('status', 'active')->count();
        $expiredMembers = Member::where('status', 'expired')->count();

        // 2. Count Total Plans
        $totalPlans = Plan::count();

        // 3. Calculate Revenue (Fixes the $monthlyRevenue error)
        $monthlyRevenue = Member::sum('price'); 

        // 4. Get members expiring in the next 7 days
        $expiringSoon = Member::where('end_date', '>', now())
                                ->where('end_date', '<=', now()->addDays(7))
                                ->with('plan') // Load plan relationship
                                ->get();

        return view('dashboard', compact(
            'totalMembers', 
            'activeMembers', 
            'expiredMembers', 
            'totalPlans', 
            'monthlyRevenue', 
            'expiringSoon'
        ));
    }
}