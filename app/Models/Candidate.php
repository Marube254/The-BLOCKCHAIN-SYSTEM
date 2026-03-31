<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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
        'photo_path',
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
        return $this->belongsTo(Sector::class, 'sector', 'sector_name');
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    // Get photo URL
    public function getPhotoUrlAttribute()
    {
        if ($this->photo_path) {
            return Storage::url($this->photo_path);
        }
        if ($this->photo_filename) {
            return asset('storage/' . $this->photo_filename);
        }
        return null;
    }
}