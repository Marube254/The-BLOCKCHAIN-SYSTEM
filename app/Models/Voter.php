<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Voter extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'voters';

    protected $fillable = [
        'first_name',
        'last_name',
        'voter_id',
        'email',
        'password',
        'has_voted',
        'voted_at',
        'fingerprint',
        'faculty',
        'faculty_code',
        'program',
        'year_of_study'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'has_voted' => 'boolean',
        'voted_at' => 'datetime',
        'email_verified_at' => 'datetime',
    ];

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }
}