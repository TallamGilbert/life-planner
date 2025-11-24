<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
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
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

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
     * Get all bill payments for the user
     */
    public function billPayments()
    {
        return $this->hasMany(BillPayment::class);
    }
}