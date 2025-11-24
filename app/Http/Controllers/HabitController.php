<?php

namespace App\Http\Controllers;

use App\Models\Habit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class HabitController extends Controller
{
    /**
     * Display a listing of habits
     */
    public function index()
    {
        $habits = Auth::user()->habits()
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('habits.index', compact('habits'));
    }

    /**
     * Show the form for creating a new habit
     */
    public function create()
    {
        return view('habits.create');
    }

    /**
     * Store a newly created habit
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        Auth::user()->habits()->create([
            'name' => $validated['name'],
            'category' => $validated['category'],
            'description' => $validated['description'] ?? null,
            'streak' => 0,
            'longest_streak' => 0,
            'last_completed' => null,
            'is_active' => true,
        ]);

        return redirect()->route('habits.index')
            ->with('success', 'Habit created successfully!');
    }

    /**
     * Check in a habit (mark as done today)
     */
    public function checkin(Habit $habit)
    {
        // Make sure user owns this habit
        if ($habit->user_id !== Auth::id()) {
            abort(403);
        }

        $today = Carbon::today();
        $lastCompleted = $habit->last_completed ? Carbon::parse($habit->last_completed) : null;

        // Check if already completed today
        if ($lastCompleted && $lastCompleted->isToday()) {
            return redirect()->route('habits.index')
                ->with('info', 'Already checked in today!');
        }

        // Check if completed yesterday (continue streak)
        if ($lastCompleted && $lastCompleted->isYesterday()) {
            $habit->streak += 1;
        } 
        // Check if completed today (shouldn't happen, but handle it)
        elseif ($lastCompleted && $lastCompleted->isToday()) {
            // Do nothing, already done today
        }
        // Otherwise, streak is broken, start over
        else {
            $habit->streak = 1;
        }

        // Update longest streak if current streak is higher
        if ($habit->streak > $habit->longest_streak) {
            $habit->longest_streak = $habit->streak;
        }

        $habit->last_completed = $today;
        $habit->save();

        return redirect()->route('habits.index')
            ->with('success', "🔥 Checked in! Current streak: {$habit->streak} days!");
    }

    /**
     * Show the form for editing a habit
     */
    public function edit(Habit $habit)
    {
        // Make sure user owns this habit
        if ($habit->user_id !== Auth::id()) {
            abort(403);
        }

        return view('habits.edit', compact('habit'));
    }

    /**
     * Update the specified habit
     */
    public function update(Request $request, Habit $habit)
    {
        // Make sure user owns this habit
        if ($habit->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
        ]);

        $habit->update($validated);

        return redirect()->route('habits.index')
            ->with('success', 'Habit updated successfully!');
    }

    /**
     * Remove the specified habit
     */
    public function destroy(Habit $habit)
    {
        // Make sure user owns this habit
        if ($habit->user_id !== Auth::id()) {
            abort(403);
        }

        $habit->delete();

        return redirect()->route('habits.index')
            ->with('success', 'Habit deleted successfully!');
    }

    /**
     * Archive a habit (mark as inactive)
     */
    public function archive(Habit $habit)
    {
        // Make sure user owns this habit
        if ($habit->user_id !== Auth::id()) {
            abort(403);
        }

        $habit->is_active = false;
        $habit->save();

        return redirect()->route('habits.index')
            ->with('success', 'Habit archived successfully!');
    }
}