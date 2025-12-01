<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DemoController extends Controller
{
    /**
     * Start demo session
     */
    public function start()
    {
        // Check if already logged in
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        // Create demo user
        $demoUser = User::create([
            'name' => 'Demo User',
            'email' => 'demo_' . Str::random(10) . '@demo.local',
            'password' => Hash::make(Str::random(20)),
            'is_demo' => true,
            'demo_expires_at' => now()->addHour(),
            'email_verified_at' => now(),
        ]);

        // Create sample data for demo user
        $this->createSampleData($demoUser);

        // Login the demo user
        Auth::login($demoUser);

        return redirect()->route('dashboard')
            ->with('success', '🎉 Welcome to Demo Mode! You have 1 hour to explore all features.');
    }

    /**
     * Create sample data for demo user
     */
    private function createSampleData(User $user)
    {
        // Create sample expenses
        $user->expenses()->createMany([
            [
                'name' => 'Salary',
                'amount' => 3000.00,
                'type' => 'income',
                'category' => 'Salary',
                'date' => now()->subDays(5),
            ],
            [
                'name' => 'Groceries',
                'amount' => 150.75,
                'type' => 'expense',
                'category' => 'Food',
                'date' => now()->subDays(2),
            ],
            [
                'name' => 'Coffee',
                'amount' => 5.50,
                'type' => 'expense',
                'category' => 'Food',
                'date' => now()->subDays(1),
            ],
            [
                'name' => 'Transport',
                'amount' => 60.00,
                'type' => 'expense',
                'category' => 'Transport',
                'date' => now(),
            ],
        ]);

        // Create sample habits
        $user->habits()->createMany([
            [
                'name' => 'Morning Exercise',
                'category' => 'Health',
                'description' => '30 minutes of exercise',
                'streak' => 7,
                'longest_streak' => 12,
                'last_completed' => now(),
                'is_active' => true,
            ],
            [
                'name' => 'Read 30 Minutes',
                'category' => 'Learning',
                'description' => 'Read books daily',
                'streak' => 5,
                'longest_streak' => 8,
                'last_completed' => now(),
                'is_active' => true,
            ],
            [
                'name' => 'Meditation',
                'category' => 'Mindfulness',
                'description' => '10 minutes of meditation',
                'streak' => 3,
                'longest_streak' => 10,
                'last_completed' => now()->subDay(),
                'is_active' => true,
            ],
        ]);

        // Create sample meals
        $mealTypes = ['breakfast', 'lunch', 'dinner'];
        for ($i = 0; $i < 3; $i++) {
            foreach ($mealTypes as $type) {
                $user->meals()->create([
                    'name' => ucfirst($type) . ' - Day ' . ($i + 1),
                    'meal_type' => $type,
                    'date' => now()->addDays($i),
                    'recipe' => 'Sample recipe for ' . $type,
                    'ingredients' => "- Ingredient 1\n- Ingredient 2\n- Ingredient 3",
                ]);
            }
        }

        // Create sample bill
        $user->bills()->create([
            'name' => 'Laptop Payment',
            'total_amount' => 1200.00,
            'paid_amount' => 400.00,
            'total_installments' => 12,
            'paid_installments' => 4,
            'installment_amount' => 100.00,
            'frequency' => 'monthly',
            'start_date' => now()->subMonths(4),
            'next_due_date' => now()->addDays(15),
            'category' => 'Electronics',
            'is_active' => true,
        ]);
    }

    /**
     * End demo and prompt signup
     */
    public function end()
    {
        if (Auth::check() && Auth::user()->is_demo) {
            $userId = Auth::id();
            Auth::logout();
            
            // Delete demo user data
            User::where('id', $userId)->delete();
        }

        return redirect()->route('register')
            ->with('info', 'Demo session ended. Sign up to keep your data and continue using Life Planner!');
    }

    /**
     * Convert demo to real account
     */
    public function convert(Request $request)
    {
        if (!Auth::check() || !Auth::user()->is_demo) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'is_demo' => false,
            'demo_expires_at' => null,
        ]);

        return redirect()->route('dashboard')
            ->with('success', '🎉 Account created! All your demo data has been saved.');
    }
}