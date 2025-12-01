<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Expense;
use App\Models\Habit;
use App\Models\Meal;
use App\Models\Bill;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Admin Dashboard
     */
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'demo_users' => User::where('is_demo', true)->count(),
            'active_users' => User::where('is_demo', false)->count(),
            'total_expenses' => Expense::count(),
            'total_habits' => Habit::count(),
            'total_meals' => Meal::count(),
            'total_bills' => Bill::count(),
            'recent_users' => User::latest()->take(10)->get(),
        ];

        return view('admin.dashboard', $stats);
    }

    /**
     * List all users
     */
    public function users()
    {
        $users = User::withCount(['expenses', 'habits', 'meals', 'bills'])
            ->latest()
            ->paginate(20);

        return view('admin.users', compact('users'));
    }

    /**
     * View user details
     */
    public function showUser(User $user)
    {
        $user->load(['expenses', 'habits', 'meals', 'bills']);
        
        return view('admin.user-details', compact('user'));
    }

    /**
     * Delete user
     */
    public function deleteUser(User $user)
    {
        if ($user->is_admin) {
            return back()->with('error', 'Cannot delete admin user!');
        }

        $user->delete();

        return redirect()->route('admin.users')
            ->with('success', 'User deleted successfully!');
    }

    /**
     * Make user admin
     */
    public function makeAdmin(User $user)
    {
        $user->update(['is_admin' => true]);

        return back()->with('success', 'User is now an admin!');
    }

    /**
     * Remove admin
     */
    public function removeAdmin(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot remove yourself as admin!');
        }

        $user->update(['is_admin' => false]);

        return back()->with('success', 'Admin privileges removed!');
    }

    /**
     * System stats
     */
    public function stats()
    {
        $stats = [
            'users_by_month' => User::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
                ->groupBy('month')
                ->orderBy('month', 'desc')
                ->take(6)
                ->get(),
            
            'expenses_by_category' => Expense::selectRaw('category, COUNT(*) as count, SUM(amount) as total')
                ->where('type', 'expense')
                ->groupBy('category')
                ->get(),
            
            'popular_habits' => Habit::selectRaw('category, COUNT(*) as count')
                ->groupBy('category')
                ->get(),
        ];

        return view('admin.stats', $stats);
    }
}