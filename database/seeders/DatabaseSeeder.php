<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ClubSeeder::class,
            CourseSeeder::class,
            ClubCompetitionSeeder::class,
        ]);

        User::factory()->create([
            'name' => 'Bradley Exall',
            'email' => 'bradley@exallgroup.com',
            'club_id' => 1,
            'password' => bcrypt('titleist04'),
        ]);

        $this->call([
            TournamentWeekSeeder::class,
        ]);
    }
}
