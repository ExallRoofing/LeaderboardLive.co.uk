<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\TournamentWeek;

class TournamentWeekSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $startDate = Carbon::now()->startOfWeek(Carbon::MONDAY); // Start on the upcoming Monday
        $weeksToCreate = 52;

        for ($i = 0; $i < $weeksToCreate; $i++) {
            $weekStart = $startDate->copy()->addWeeks($i);
            $weekEnd = $weekStart->copy()->endOfWeek(Carbon::SUNDAY);
            $weekNumber = $weekStart->format('o-\WW'); // e.g., 2025-W23

            TournamentWeek::create([
                'week_number' => $weekNumber,
                'start_date' => $weekStart->toDateString(),
                'end_date' => $weekEnd->toDateString(),
                'is_active' => $i === 0, // First week is active
            ]);
        }
    }
}
