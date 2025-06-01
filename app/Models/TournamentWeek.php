<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TournamentWeek extends Model
{
    use HasFactory;

    protected $fillable = [
        'week_number',
        'start_date',
        'end_date',
        'is_active',
        'closed_at',
    ];

    /**
     * A tournament week includes many club competitions.
     */
    public function clubCompetitions()
    {
        return $this->hasMany(ClubCompetition::class);
    }

    /**
     * Aggregate entries through club competitions.
     */
    public function entries()
    {
        return $this->hasManyThrough(Entry::class, ClubCompetition::class);
    }
}
