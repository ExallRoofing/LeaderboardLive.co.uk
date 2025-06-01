<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompetitionMedia extends Model
{
    public function competition()
    {
        return $this->belongsTo(ClubCompetition::class, 'competition_id');
    }
}
