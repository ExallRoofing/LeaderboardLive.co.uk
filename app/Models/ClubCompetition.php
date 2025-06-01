<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClubCompetition extends Model
{
    use HasFactory;

    protected $fillable = [
        'club_id',
        'tournament_week_id',
        'competition_name',
        'competition_date',
        'registration_deadline',
        'is_open',
    ];

    protected $casts = [
        'competition_date' => 'datetime',
        'registration_deadline' => 'datetime',
    ];

    /**
     * This competition belongs to a club.
     */
    public function club()
    {
        return $this->belongsTo(Club::class);
    }

    /**
     * This competition belongs to a national tournament week.
     */
    public function tournamentWeek()
    {
        return $this->belongsTo(TournamentWeek::class);
    }

    /**
     * Entries submitted to this club's weekly competition.
     */
    public function entries()
    {
        return $this->hasMany(Entry::class);
    }

    /**
     * This competition belongs to a course.
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Notices submitted to the competition.
     */
    public function notices()
    {
        return $this->hasMany(Notice::class);
    }

    /**
     * Media uploaded for the competition.
     */
    public function media()
    {
        return $this->hasMany(CompetitionMedia::class, 'competition_id');
    }
}
