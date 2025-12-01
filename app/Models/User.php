<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_picture_path',
        'is_demo',
        'demo_expires_at',
        'is_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_demo' => 'boolean',
        'demo_expires_at' => 'datetime',
        'is_admin' => 'boolean',
    ];

    /**
     * Get all expenses for the user
     */
    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    /**
     * Get all habits for the user
     */
    public function habits()
    {
        return $this->hasMany(Habit::class);
    }

    /**
     * Get all meals for the user
     */
    public function meals()
    {
        return $this->hasMany(Meal::class);
    }

    /**
     * Get all bills for the user
     */
    public function bills()
    {
        return $this->hasMany(Bill::class);
    }

    /**
 * Check if user is admin
        */
        public function isAdmin()
        {
            return $this->is_admin;
        }

    /**
     * Get all bill payments for the user
     */
    public function billPayments()
    {
        return $this->hasMany(BillPayment::class);
    }

    /**
     * Check if demo session is expired
     */
    public function isDemoExpired()
    {
        return $this->is_demo && $this->demo_expires_at && now()->greaterThan($this->demo_expires_at);
    }

    /**
     * Get remaining demo time in minutes
     */
public function getDemoTimeRemaining()
{
    if (!$this->is_demo || !$this->demo_expires_at) {
        return 0;
    }

    $seconds = now()->diffInSeconds($this->demo_expires_at, false);

    $minutes = $seconds / 60;

    return $minutes > 0 ? $minutes : 0;
}

}