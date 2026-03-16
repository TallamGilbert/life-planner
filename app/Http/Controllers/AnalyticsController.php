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

        // Fetch all expenses for last 6 months in a single query
        $sixMonthsAgo = Carbon::now()->subMonths(6);
        $allExpenses = $user->expenses()
            ->where('date', '>=', $sixMonthsAgo)
            ->get();

        // Build 6-month data by grouping results in PHP
        $last6Months = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $monthStart = $month->copy()->startOfMonth();
            $monthEnd = $month->copy()->endOfMonth();

            $income = $allExpenses
                ->whereBetween('date', [$monthStart, $monthEnd])
                ->where('type', 'income')
                ->sum('amount');

            $expenses = $allExpenses
                ->whereBetween('date', [$monthStart, $monthEnd])
                ->where('type', 'expense')
                ->sum('amount');

            $last6Months[] = [
                'month' => $month->format('M Y'),
                'income' => $income,
                'expenses' => $expenses,
            ];
        }

        // Habit Analytics - fetch all active habits once
        $activeHabits = $user->habits()
            ->where('is_active', true)
            ->get();

        $habitProgress = $activeHabits->map(function($habit) {
            return [
                'name' => $habit->name,
                'current_streak' => $habit->streak,
                'longest_streak' => $habit->longest_streak,
            ];
        });

        // Habit completion rate (last 30 days) - group results in PHP
        $totalHabits = $activeHabits->count();
        $last30Days = [];

        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);

            // Count habits completed on this date from already-loaded data
            $completedHabits = $activeHabits->filter(function($habit) use ($date) {
                return $habit->last_completed && $habit->last_completed->toDateString() === $date->toDateString();
            })->count();

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