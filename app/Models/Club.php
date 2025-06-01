<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'contact_email',
    ];

    /**
     * A club has many users (players).
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * A club can submit multiple competitions (one per week).
     */
    public function clubCompetitions()
    {
        return $this->hasMany(ClubCompetition::class);
    }

    /**
     * A club has many courses.
     */
    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
