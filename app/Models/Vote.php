<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;

    protected $table = 'votes';

    protected $fillable = [
        'voter_id',
        'candidate_id',
        'sector',
        'blockchain_hash',
        'previous_hash',
        'block_index',
        'confirmed_at',
        'ip_address',
        'user_agent',
        'voted_at'
    ];

    protected $casts = [
        'confirmed_at' => 'datetime',
        'voted_at' => 'datetime',
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