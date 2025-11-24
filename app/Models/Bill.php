<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Bill extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'total_amount',
        'paid_amount',
        'total_installments',
        'paid_installments',
        'installment_amount',
        'frequency',
        'start_date',
        'next_due_date',
        'category',
        'notes',
        'is_active',
    ];

    protected $casts = [
        'start_date' => 'date',
        'next_due_date' => 'date',
        'total_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'installment_amount' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payments()
    {
        return $this->hasMany(BillPayment::class);
    }

    // Calculate remaining amount
    public function getRemainingAmountAttribute()
    {
        return $this->total_amount - $this->paid_amount;
    }

    // Calculate remaining installments
    public function getRemainingInstallmentsAttribute()
    {
        return $this->total_installments - $this->paid_installments;
    }

    // Check if bill is overdue
    public function getIsOverdueAttribute()
    {
        return $this->next_due_date && $this->next_due_date->isPast() && $this->is_active;
    }

    // Calculate progress percentage
    public function getProgressPercentageAttribute()
    {
        return $this->total_amount > 0 
            ? round(($this->paid_amount / $this->total_amount) * 100, 1) 
            : 0;
    }
}