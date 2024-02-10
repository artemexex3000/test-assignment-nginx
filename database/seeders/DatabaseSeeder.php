<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Position;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Position::insert([
            'id' => 1,
            'name' => 'Security',
        ]);
        Position::insert([
            'id' => 2,
            'name' => 'Designer',
        ]);
        Position::insert([
            'id' => 3,
            'name' => 'Content manager',
        ]);
        Position::insert([
            'id' => 4,
            'name' => 'Lawyer',
        ]);
        User::factory()->count(45)->create();
    }
}
