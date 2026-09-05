<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (User::where('email', 'test@example.com')->doesntExist() && User::count() === 0) {
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'rut' => '12345678-9',
            ]);
        }

        $this->call([
            ProfesorSeeder::class,
            AlumnoSeeder::class,
            HabilitacionSeeder::class,
        ]);
    }
}
