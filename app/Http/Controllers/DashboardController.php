<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Coach;
use App\Models\Plan;
use App\Models\Expense;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $now = Carbon::now();

        // 1. General Statistics
        $totalMembers = Member::count();
        $activeMembers = Member::where('status', 'active')->count();
        $expiredMembers = Member::where('status', 'expired')->count();
        $totalPlans = Plan::count();
        $totalCoaches = Coach::count();

        // 2. Current Month Financials (Revenue vs Expenses)
        $currentMonthlyRevenue = Member::whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year)
            ->sum('price');

        $currentMonthlyExpenses = Expense::whereMonth('date', $now->month)
            ->whereYear('date', $now->year)
            ->sum('amount');

        $netProfit = $currentMonthlyRevenue - $currentMonthlyExpenses;

        // 3. Chart Data (Logic for the last 3 months)
        $chartData = [
            'labels' => [],
            'revenue' => [],
            'expenses' => []
        ];

        for ($i = 2; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $monthLabel = $month->format('M Y');
            
            // Calculate Revenue for that specific month
            $rev = Member::whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->sum('price');
            
            // Calculate Expenses for that specific month
            $exp = Expense::whereMonth('date', $month->month)
                ->whereYear('date', $month->year)
                ->sum('amount');

            $chartData['labels'][] = $monthLabel;
            $chartData['revenue'][] = $rev;
            $chartData['expenses'][] = $exp;
        }

        // 4. Expiring Soon (Next 7 Days)
        $expiringSoon = Member::with('plan')
            ->whereBetween('end_date', [
                $now->copy()->startOfDay(), 
                $now->copy()->addDays(7)->endOfDay()
            ])
            ->orderBy('end_date', 'asc')
            ->get();

        return view('dashboard', compact(
            'totalMembers',
            'activeMembers',
            'expiredMembers',
            'totalPlans',
            'totalCoaches',
            'currentMonthlyRevenue',
            'currentMonthlyExpenses',
            'netProfit',
            'chartData',
            'expiringSoon'
        ));
    }
}