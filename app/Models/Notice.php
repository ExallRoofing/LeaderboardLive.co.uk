<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    protected $fillable = ['club_competition_id', 'title', 'body', 'published_at'];

    public function competition()
    {
        return $this->belongsTo(ClubCompetition::class, 'club_competition_id');
    }
}
