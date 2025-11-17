<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $fillable = [
        'voter_id',
        'candidate_id',
        'sector',
        'confirmed_at',
       // 'metadata',
    ];

    protected $casts = [
       // 'metadata' => 'array',
        'confirmed_at' => 'datetime',
    ];

    public function voter()
    {
        return $this->belongsTo(Voter::class);
    }

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }
}
