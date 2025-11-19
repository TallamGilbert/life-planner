<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Expense;
use App\Models\Habit;
use App\Models\Meal;
use Illuminate\Support\Facades\Hash;

class DashboardTestSeeder extends Seeder
{
    public function run(): void
    {
        // Create a test user if none exists
        $user = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password'),
            ]
        );

        // Create sample expenses
        $expenses = [
            ['name' => 'Groceries', 'amount' => 150.75, 'category' => 'Food', 'type' => 'expense'],
            ['name' => 'Transport', 'amount' => 60.00, 'category' => 'Transport', 'type' => 'expense'],
            ['name' => 'Salary', 'amount' => 3000.00, 'category' => 'Income', 'type' => 'income'],
            ['name' => 'Coffee', 'amount' => 5.50, 'category' => 'Food', 'type' => 'expense'],
            ['name' => 'Gym', 'amount' => 50.00, 'category' => 'Health', 'type' => 'expense'],
        ];

        foreach ($expenses as $expense) {
            Expense::create(array_merge($expense, [
                'user_id' => $user->id,
                'date' => now()->subDays(rand(0, 7)),
            ]));
        }

        // Create sample habits
        $habits = [
            ['name' => 'Daily Run', 'streak' => 7, 'category' => 'Fitness'],
            ['name' => 'Read Book', 'streak' => 5, 'category' => 'Learning'],
            ['name' => 'Meditation', 'streak' => 12, 'category' => 'Wellness'],
            ['name' => 'Drink Water', 'streak' => 3, 'category' => 'Health'],
        ];

        foreach ($habits as $habit) {
            Habit::create(array_merge($habit, [
                'user_id' => $user->id,
                'longest_streak' => $habit['streak'] + rand(0, 5),
                'last_completed' => now(),
            ]));
        }

        // Create sample meals for the week
        $mealTypes = ['breakfast', 'lunch', 'dinner'];
        
        for ($i = 0; $i < 7; $i++) {
            foreach ($mealTypes as $type) {
                Meal::create([
                    'user_id' => $user->id,
                    'name' => ucfirst($type) . ' - Day ' . ($i + 1),
                    'meal_type' => $type,
                    'date' => now()->addDays($i),  // This was missing!
                    'recipe' => 'Sample recipe for ' . $type,
                ]);
            }
        }

        $this->command->info('✅ Test data created successfully!');
        $this->command->info('📧 Email: test@example.com');
        $this->command->info('🔑 Password: password');
    }
}