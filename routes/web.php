<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\HabitController;
use App\Http\Controllers\MealController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\DemoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Demo routes (public)
Route::get('/demo/start', [DemoController::class, 'start'])->name('demo.start');

// Authenticated routes
Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::delete('/profile-picture', [ProfileController::class, 'deleteProfilePicture'])->name('profile.picture.delete');
    
    // Demo routes (authenticated)
    Route::post('/demo/end', [DemoController::class, 'end'])->name('demo.end');
    Route::post('/demo/convert', [DemoController::class, 'convert'])->name('demo.convert');
    Route::get('/demo/time-remaining', function () {
        if (!auth()->check() || !auth()->user()->is_demo) {
            return response()->json(['minutes' => 0]);
        }
        
        return response()->json([
            'minutes' => auth()->user()->getDemoTimeRemaining()
        ]);
    })->name('demo.time-remaining');
    
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


    // Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\AdminController::class, 'index'])->name('dashboard');
    Route::get('/users', [App\Http\Controllers\Admin\AdminController::class, 'users'])->name('users');
    Route::get('/users/{user}', [App\Http\Controllers\Admin\AdminController::class, 'showUser'])->name('users.show');
    Route::delete('/users/{user}', [App\Http\Controllers\Admin\AdminController::class, 'deleteUser'])->name('users.delete');
    Route::post('/users/{user}/make-admin', [App\Http\Controllers\Admin\AdminController::class, 'makeAdmin'])->name('users.make-admin');
    Route::post('/users/{user}/remove-admin', [App\Http\Controllers\Admin\AdminController::class, 'removeAdmin'])->name('users.remove-admin');
    Route::get('/stats', [App\Http\Controllers\Admin\AdminController::class, 'stats'])->name('stats');

      // Activity Logs
    Route::get('/logs', [App\Http\Controllers\Admin\ActivityLogController::class, 'index'])->name('logs');
    Route::get('/logs/{log}', [App\Http\Controllers\Admin\ActivityLogController::class, 'show'])->name('logs.show');
    Route::delete('/logs/{log}', [App\Http\Controllers\Admin\ActivityLogController::class, 'destroy'])->name('logs.delete');
    Route::post('/logs/clear', [App\Http\Controllers\Admin\ActivityLogController::class, 'clear'])->name('logs.clear');
    
    // Settings
    Route::get('/settings', [App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('settings');
    Route::post('/settings', [App\Http\Controllers\Admin\SettingsController::class, 'update'])->name('settings.update');
});
});

require __DIR__.'/auth.php';