<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // <- change here
use Illuminate\Notifications\Notifiable;

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
        'password',           // added for password login
        'fingerprint_data',   // already present, used for fingerprint login
        'registered_at',
        'has_voted',
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
}
