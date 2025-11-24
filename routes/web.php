<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ExpenseController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HabitController;
use App\Http\Controllers\MealController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\BillController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::delete('/profile-picture', [ProfileController::class, 'deleteProfilePicture'])->name('profile.picture.delete');
    
    // Expense routes
    Route::resource('expenses', ExpenseController::class);

    // Habit routes
    Route::resource('habits', HabitController::class);
    Route::post('habits/{habit}/checkin', [HabitController::class, 'checkin'])->name('habits.checkin');
    Route::post('habits/{habit}/archive', [HabitController::class, 'archive'])->name('habits.archive');

      // Meal routes
    Route::resource('meals', MealController::class);
    Route::get('meals-shopping-list', [MealController::class, 'shoppingList'])->name('meals.shopping-list');

     // Analytics route
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics.index');

    // Bills routes
    Route::resource('bills', BillController::class);
    Route::post('bills/{bill}/payment', [BillController::class, 'recordPayment'])->name('bills.payment');
});
require __DIR__.'/auth.php';