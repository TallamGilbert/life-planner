<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPreference extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'timezone',
        'email_notifications_enabled',
        'email_summary_enabled',
        'email_summary_frequency',
    ];

    protected $casts = [
        'email_notifications_enabled' => 'boolean',
        'email_summary_enabled' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
