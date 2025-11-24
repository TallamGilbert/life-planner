<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MealController extends Controller
{
    /**
     * Display weekly meal planner
     */
    public function index()
    {
        // Get current week's meals
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
        
        $meals = Auth::user()->meals()
            ->whereBetween('date', [$startOfWeek, $endOfWeek])
            ->orderBy('date')
            ->orderBy('meal_type')
            ->get();
        
        // Group meals by date and type
        $mealsByDate = $meals->groupBy(function($meal) {
            return $meal->date->format('Y-m-d');
        });
        
        return view('meals.index', compact('mealsByDate', 'startOfWeek', 'endOfWeek'));
    }

    /**
     * Show the form for creating a new meal
     */
    public function create()
    {
        return view('meals.create');
    }

    /**
     * Store a newly created meal
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'meal_type' => 'required|in:breakfast,lunch,dinner,snack',
            'date' => 'required|date',
            'recipe' => 'nullable|string',
            'ingredients' => 'nullable|string',
            'notes' => 'nullable|string|max:1000',
        ]);

        Auth::user()->meals()->create($validated);

        return redirect()->route('meals.index')
            ->with('success', 'Meal added successfully!');
    }

    /**
     * Show the form for editing a meal
     */
    public function edit(Meal $meal)
    {
        // Make sure user owns this meal
        if ($meal->user_id !== Auth::id()) {
            abort(403);
        }

        return view('meals.edit', compact('meal'));
    }

    /**
     * Update the specified meal
     */
    public function update(Request $request, Meal $meal)
    {
        // Make sure user owns this meal
        if ($meal->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'meal_type' => 'required|in:breakfast,lunch,dinner,snack',
            'date' => 'required|date',
            'recipe' => 'nullable|string',
            'ingredients' => 'nullable|string',
            'notes' => 'nullable|string|max:1000',
        ]);

        $meal->update($validated);

        return redirect()->route('meals.index')
            ->with('success', 'Meal updated successfully!');
    }

    /**
     * Remove the specified meal
     */
    public function destroy(Meal $meal)
    {
        // Make sure user owns this meal
        if ($meal->user_id !== Auth::id()) {
            abort(403);
        }

        $meal->delete();

        return redirect()->route('meals.index')
            ->with('success', 'Meal deleted successfully!');
    }

    /**
     * Generate shopping list for the week
     */
    public function shoppingList()
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
        
        $meals = Auth::user()->meals()
            ->whereBetween('date', [$startOfWeek, $endOfWeek])
            ->whereNotNull('ingredients')
            ->get();
        
        return view('meals.shopping-list', compact('meals', 'startOfWeek', 'endOfWeek'));
    }
}