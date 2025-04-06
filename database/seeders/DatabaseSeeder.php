<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Source;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Source::create([
            'user_id' => $user->id,
            'type' => 'ics',
            'ics_url' => 'https://example.com/calendar.ics',
        ]);
    }
}
