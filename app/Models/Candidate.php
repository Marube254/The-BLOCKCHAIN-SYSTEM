<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;

    protected $table = 'candidates';

    protected $fillable = [
        'candidate_id',
        'first_name',
        'last_name',
        'display_name',
        'photo_filename',
        'faculty',
        'faculty_code',
        'program',
        'year_of_study',
        'sector',
        'sector_code',
        'candidate_number',
        'manifesto',
        'bio',
        'contact_email',
        'status',
        'registered_at'
    ];

    protected $casts = [
        'status' => 'string',
    ];

    public function sector()
    {
        return $this->belongsTo(Sector::class, 'sector', 'sector_code');
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }
}