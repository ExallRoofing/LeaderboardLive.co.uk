<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Club;
use App\Models\Course;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $club = Club::where('name', 'Chelmsford Golf Club')->first();

        if (! $club) {
            $this->command->warn('Chelmsford Golf Club not found. Run GolfClubSeeder first.');
            return;
        }

        $holeData = [
            ['hole' => 1,  'par' => 4, 'si' => 13, 'yardage' => 330],
            ['hole' => 2,  'par' => 4, 'si' => 5,  'yardage' => 410],
            ['hole' => 3,  'par' => 3, 'si' => 17, 'yardage' => 150],
            ['hole' => 4,  'par' => 5, 'si' => 1,  'yardage' => 520],
            ['hole' => 5,  'par' => 4, 'si' => 9,  'yardage' => 360],
            ['hole' => 6,  'par' => 3, 'si' => 15, 'yardage' => 170],
            ['hole' => 7,  'par' => 4, 'si' => 11, 'yardage' => 375],
            ['hole' => 8,  'par' => 5, 'si' => 7,  'yardage' => 500],
            ['hole' => 9,  'par' => 4, 'si' => 3,  'yardage' => 420],
            ['hole' => 10, 'par' => 4, 'si' => 8,  'yardage' => 385],
            ['hole' => 11, 'par' => 5, 'si' => 2,  'yardage' => 540],
            ['hole' => 12, 'par' => 3, 'si' => 18, 'yardage' => 145],
            ['hole' => 13, 'par' => 4, 'si' => 6,  'yardage' => 405],
            ['hole' => 14, 'par' => 4, 'si' => 10, 'yardage' => 370],
            ['hole' => 15, 'par' => 4, 'si' => 12, 'yardage' => 360],
            ['hole' => 16, 'par' => 3, 'si' => 16, 'yardage' => 160],
            ['hole' => 17, 'par' => 5, 'si' => 4,  'yardage' => 510],
            ['hole' => 18, 'par' => 4, 'si' => 14, 'yardage' => 400],
        ];

        Course::updateOrCreate(
            [
                'club_id' => $club->id,
                'name' => 'Chelmsford Championship Course',
                'tees' => 'White',
            ],
            [
                'par' => 70,
                'sss' => 70.3,
                'holes' => 18,
                'yardage' => collect($holeData)->sum('yardage'),
                'rating' => 70.3,
                'slope_rating' => 125,
                'hole_data' => $holeData,
                'is_active' => true,
            ]
        );
    }
}
