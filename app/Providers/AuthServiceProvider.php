<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Bill;
use App\Models\Expense;
use App\Models\Meal;
use App\Models\Habit;
use App\Policies\BillPolicy;
use App\Policies\ExpensePolicy;
use App\Policies\MealPolicy;
use App\Policies\HabitPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Bill::class => BillPolicy::class,
        Expense::class => ExpensePolicy::class,
        Meal::class => MealPolicy::class,
        Habit::class => HabitPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
