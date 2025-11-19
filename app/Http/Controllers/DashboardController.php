<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\Habit;
use App\Models\Meal;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // get logged-in user

        $budget = Expense::where('user_id', $user->id)->sum('amount');
        $streaks = Habit::where('user_id', $user->id)->sum('streak');
        $meals = Meal::where('user_id', $user->id)
                     ->whereBetween('date', [now()->startOfWeek(), now()->endOfWeek()])
                     ->count();

        // Pass variables to the Blade view
        return view('dashboard', compact('budget', 'streaks', 'meals'));
    }
}
