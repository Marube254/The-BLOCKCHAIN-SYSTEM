<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;

    protected $fillable = [
        'candidate_id',
        'first_name',
        'last_name',
        'display_name',
        'photo_filename',
        'faculty',
        'faculty_code',
        //'department',
        'program',
        'year_of_study',
        'sector',
        'sector_code',
        'candidate_number',
        'manifesto',
        'bio',
        'contact_email',
        'status',
        'registered_at',
       // 'metadata',
    ];

    protected $casts = [
       // 'metadata' => 'array',
        'registered_at' => 'datetime',
    ];

    // Relationships
    public function sector()
    {
        return $this->belongsTo(Sector::class);
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }
}
