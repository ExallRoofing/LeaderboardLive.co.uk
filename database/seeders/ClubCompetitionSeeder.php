<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Club;
use App\Models\ClubCompetition;
use App\Models\TournamentWeek;
use Illuminate\Support\Carbon;

class ClubCompetitionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $club = Club::where('name', 'Chelmsford Golf Club')->first();
        $week = TournamentWeek::firstOrCreate(
            ['week_number' => 1],
            [
                'start_date' => now()->startOfWeek()->addDays(5),
                'end_date' => now()->startOfWeek()->addDays(11),
                'is_active' => true,
            ]
        );

        ClubCompetition::updateOrCreate(
            [
                'club_id' => $club->id,
                'tournament_week_id' => $week->id,
                'competition_name' => 'Saturday Medal',
            ],
            [
                'competition_date' => Carbon::now()->next(Carbon::SATURDAY)->toDateString(),
                'registration_deadline' => Carbon::now()->addDays(4)->setTime(18, 0),
                'is_open' => true,
            ]
        );
    }
}
