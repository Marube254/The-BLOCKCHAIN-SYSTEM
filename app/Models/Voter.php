<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\VoterResetPasswordNotification;

class Voter extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'voter_id',
        'first_name',
        'last_name',
        'email',
        'faculty',
        'faculty_code',
        'program',
        'year_of_study',
        'status',
        'password',
        'fingerprint_data',
        'fingerprint_hash',
        'registered_at',
        'has_voted',
        'remember_token',
        //'metadata',
    ];

    protected $hidden = [
        'password',
        'fingerprint_data',
    ];

    protected $casts = [
        //'metadata' => 'array',
        'registered_at' => 'datetime',
    ];

    // Relationships
    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new VoterResetPasswordNotification($token));
    }

    /**
     * Get the email address for password resets.
     *
     * @return string
     */
    public function getEmailForPasswordReset()
    {
        return $this->email; // Use email for password reset
    }
}
