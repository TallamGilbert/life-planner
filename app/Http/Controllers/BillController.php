<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\BillPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BillController extends Controller
{
    /**
     * Display bills list
     */
    public function index()
    {
        $activeBills = Auth::user()->bills()
            ->where('is_active', true)
            ->orderBy('next_due_date')
            ->get();

        $completedBills = Auth::user()->bills()
            ->where('is_active', false)
            ->latest()
            ->take(10)
            ->get();

        return view('bills.index', compact('activeBills', 'completedBills'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        return view('bills.create');
    }

    /**
     * Store new bill
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'total_amount' => 'required|numeric|min:0.01',
            'total_installments' => 'required|integer|min:1',
            'frequency' => 'required|in:weekly,monthly,quarterly,yearly',
            'start_date' => 'required|date',
            'category' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Calculate installment amount
        $installmentAmount = $validated['total_amount'] / $validated['total_installments'];

        $bill = Auth::user()->bills()->create([
            'name' => $validated['name'],
            'total_amount' => $validated['total_amount'],
            'paid_amount' => 0,
            'total_installments' => $validated['total_installments'],
            'paid_installments' => 0,
            'installment_amount' => round($installmentAmount, 2),
            'frequency' => $validated['frequency'],
            'start_date' => $validated['start_date'],
            'next_due_date' => $validated['start_date'],
            'category' => $validated['category'],
            'notes' => $validated['notes'],
            'is_active' => true,
        ]);

        return redirect()->route('bills.index')
            ->with('success', 'Bill created successfully!');
    }

    /**
     * Show bill details
     */
    public function show(Bill $bill)
    {
        // Make sure user owns this bill
        if ($bill->user_id !== Auth::id()) {
            abort(403);
        }

        $payments = $bill->payments()->latest()->get();

        return view('bills.show', compact('bill', 'payments'));
    }

    /**
     * Record a payment
     */
    public function recordPayment(Request $request, Bill $bill)
    {
        // Make sure user owns this bill
        if ($bill->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'payment_date' => 'required|date',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Create payment record
        BillPayment::create([
            'bill_id' => $bill->id,
            'user_id' => Auth::id(),
            'amount' => $validated['amount'],
            'payment_date' => $validated['payment_date'],
            'notes' => $validated['notes'],
        ]);

        // Update bill
        $bill->paid_amount += $validated['amount'];
        $bill->paid_installments += 1;

        // Calculate next due date based on frequency
        if ($bill->next_due_date) {
            switch ($bill->frequency) {
                case 'weekly':
                    $bill->next_due_date = Carbon::parse($bill->next_due_date)->addWeek();
                    break;
                case 'monthly':
                    $bill->next_due_date = Carbon::parse($bill->next_due_date)->addMonth();
                    break;
                case 'quarterly':
                    $bill->next_due_date = Carbon::parse($bill->next_due_date)->addMonths(3);
                    break;
                case 'yearly':
                    $bill->next_due_date = Carbon::parse($bill->next_due_date)->addYear();
                    break;
            }
        }

        // Check if bill is fully paid
        if ($bill->paid_amount >= $bill->total_amount || 
            $bill->paid_installments >= $bill->total_installments) {
            $bill->is_active = false;
            $bill->next_due_date = null;
        }

        $bill->save();

        return redirect()->route('bills.show', $bill)
            ->with('success', 'Payment recorded successfully!');
    }

    /**
     * Edit bill
     */
    public function edit(Bill $bill)
    {
        // Make sure user owns this bill
        if ($bill->user_id !== Auth::id()) {
            abort(403);
        }

        return view('bills.edit', compact('bill'));
    }

    /**
     * Update bill
     */
    public function update(Request $request, Bill $bill)
    {
        // Make sure user owns this bill
        if ($bill->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:1000',
        ]);

        $bill->update($validated);

        return redirect()->route('bills.show', $bill)
            ->with('success', 'Bill updated successfully!');
    }

    /**
     * Delete bill
     */
    public function destroy(Bill $bill)
    {
        // Make sure user owns this bill
        if ($bill->user_id !== Auth::id()) {
            abort(403);
        }

        $bill->delete();

        return redirect()->route('bills.index')
            ->with('success', 'Bill deleted successfully!');
    }
}