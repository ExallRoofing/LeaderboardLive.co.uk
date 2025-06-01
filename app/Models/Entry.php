<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'club_competition_id',
        'net_score',
        'gross_score',
        'playing_handicap',
        'hole_by_hole_scores',
        'played_at',
        'verified',
        'paid',
    ];

    protected $casts = [
        'hole_by_hole_scores' => 'array',
        'played_at' => 'datetime',
        'verified' => 'boolean',
        'paid' => 'boolean',
        'net_score' => 'integer',
        'gross_score' => 'integer',
        'playing_handicap' => 'decimal:1',
    ];

    /**
     * Entry belongs to a player (user).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Entry belongs to a specific club competition.
     */
    public function clubCompetition()
    {
        return $this->belongsTo(ClubCompetition::class);
    }

    /**
     * Get score on a specific hole.
     */
    public function getScoreForHole(int $hole): ?int
    {
        return $this->hole_by_hole_scores[$hole - 1] ?? null;
    }

    /**
     * Helper: Total score for back 9 holes (holes 10–18).
     */
    public function getBackNineScore(): ?int
    {
        return $this->sumHoleRange(10, 18);
    }

    /**
     * Helper: Sum score over a range of holes.
     */
    protected function sumHoleRange(int $start, int $end): ?int
    {
        if (!is_array($this->hole_by_hole_scores)) {
            return null;
        }

        return collect($this->hole_by_hole_scores)
            ->slice($start - 1, $end - $start + 1)
            ->sum();
    }

    /**
     * Determine if entry is eligible for the leaderboard.
     */
    public function isEligible(): bool
    {
        return $this->paid && $this->verified;
    }
}
