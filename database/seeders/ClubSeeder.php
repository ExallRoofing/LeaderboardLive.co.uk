<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Club;

class ClubSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Club::updateOrCreate(
            ['name' => 'Chelmsford Golf Club'],
            [
                'location' => 'Chelmsford, Essex',
                'contact_email' => 'info@chelmsfordgolfclub.co.uk',
                'phone' => '01245 256483',
                'website' => 'https://www.chelmsfordgolfclub.co.uk',
                'is_active' => true,
            ]
        );
    }
}
