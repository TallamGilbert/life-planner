<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    /**
     * Display a listing of expenses
     */
    public function index()
    {
        $expenses = auth()->user()->expenses()
            ->orderBy('date', 'desc')
            ->paginate(20);
        
        return view('expenses.index', compact('expenses'));
    }

    /**
     * Show the form for creating a new expense
     */
    public function create()
    {
        return view('expenses.create');
    }

    /**
     * Store a newly created expense
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'type' => 'required|in:income,expense',
            'category' => 'required|string|max:255',
            'date' => 'required|date',
            'description' => 'nullable|string|max:1000',
        ]);

        auth()->user()->expenses()->create($validated);

        return redirect()->route('expenses.index')
            ->with('success', 'Transaction added successfully!');
    }

    /**
     * Show the form for editing an expense
     */
    public function edit(Expense $expense)
    {
        // Make sure user owns this expense
        if ($expense->user_id !== auth()->id()) {
            abort(403);
        }

        return view('expenses.edit', compact('expense'));
    }

    /**
     * Update the specified expense
     */
    public function update(Request $request, Expense $expense)
    {
        // Make sure user owns this expense
        if ($expense->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'type' => 'required|in:income,expense',
            'category' => 'required|string|max:255',
            'date' => 'required|date',
            'description' => 'nullable|string|max:1000',
        ]);

        $expense->update($validated);

        return redirect()->route('expenses.index')
            ->with('success', 'Transaction updated successfully!');
    }

    /**
     * Remove the specified expense
     */
    public function destroy(Expense $expense)
    {
        // Make sure user owns this expense
        if ($expense->user_id !== auth()->id()) {
            abort(403);
        }

        $expense->delete();

        return redirect()->route('expenses.index')
            ->with('success', 'Transaction deleted successfully!');
    }
}