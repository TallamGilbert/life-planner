<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Budget Analytics
        $expensesByCategory = $user->expenses()
            ->where('type', 'expense')
            ->selectRaw('category, SUM(amount) as total')
            ->groupBy('category')
            ->get();
        
        $last6Months = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $income = $user->expenses()
                ->where('type', 'income')
                ->whereYear('date', $month->year)
                ->whereMonth('date', $month->month)
                ->sum('amount');
            
            $expenses = $user->expenses()
                ->where('type', 'expense')
                ->whereYear('date', $month->year)
                ->whereMonth('date', $month->month)
                ->sum('amount');
            
            $last6Months[] = [
                'month' => $month->format('M Y'),
                'income' => $income,
                'expenses' => $expenses,
            ];
        }
        
        // Habit Analytics
        $habitProgress = $user->habits()
            ->where('is_active', true)
            ->get()
            ->map(function($habit) {
                return [
                    'name' => $habit->name,
                    'current_streak' => $habit->streak,
                    'longest_streak' => $habit->longest_streak,
                ];
            });
        
        // Habit completion rate (last 30 days)
        $last30Days = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $totalHabits = $user->habits()->where('is_active', true)->count();
            
            // Count habits completed on this date
            $completedHabits = $user->habits()
                ->where('is_active', true)
                ->whereDate('last_completed', $date)
                ->count();
            
            $completionRate = $totalHabits > 0 ? ($completedHabits / $totalHabits) * 100 : 0;
            
            $last30Days[] = [
                'date' => $date->format('M d'),
                'completion_rate' => round($completionRate, 1),
            ];
        }
        
        return view('analytics.index', compact(
            'expensesByCategory',
            'last6Months',
            'habitProgress',
            'last30Days'
        ));
    }
}